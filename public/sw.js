const CACHE_NAME = 'face-models-v2';
const MODEL_FILES = [
    '/storage/models/ssd_mobilenetv1_model-shard1.bin',
    '/storage/models/ssd_mobilenetv1_model-weights_manifest.json',
    '/storage/models/face_landmark_68_model-shard1.bin',
    '/storage/models/face_landmark_68_model-weights_manifest.json',
    '/storage/models/face_recognition_model-shard1.bin',
    '/storage/models/face_recognition_model-weights_manifest.json'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Attempting to cache model files');
                return Promise.all(
                    MODEL_FILES.map(url => {
                        return fetch(url)
                            .then(response => {
                                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                                return cache.put(url, response);
                            })
                            .catch(error => {
                                console.warn(`Couldn't cache ${url}:`, error);
                                // Skip failing files but continue with others
                                return Promise.resolve();
                            });
                    })
                );
            })
            .then(() => {
                console.log('Model caching completed');
                return self.skipWaiting();
            })
    );
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cache => {
                    if (cache !== CACHE_NAME) {
                        console.log('Deleting old cache:', cache);
                        return caches.delete(cache);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', event => {
    // Only handle model files
    if (!MODEL_FILES.some(url => event.request.url.includes(url))) {
        return;
    }

    event.respondWith(
        caches.match(event.request)
            .then(cached => {
                // Return cached version if available
                if (cached) {
                    console.log('Serving from cache:', event.request.url);
                    return cached;
                }

                // Otherwise fetch from network
                return fetch(event.request)
                    .then(response => {
                        // Check if we got a valid response
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }

                        // Clone the response to cache it
                        const responseToCache = response.clone();
                        caches.open(CACHE_NAME)
                            .then(cache => cache.put(event.request, responseToCache));

                        return response;
                    })
                    .catch(error => {
                        console.error('Fetch failed:', error);
                        // You could return a fallback response here if desired
                        throw error;
                    });
            })
    );
});
