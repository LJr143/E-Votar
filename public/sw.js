const CACHE_NAME = 'face-models-v1';
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
                console.log('Caching model files');
                return cache.addAll(MODEL_FILES);
            })
    );
});

self.addEventListener('fetch', (event) => {
    // Cache-first strategy for model files
    if (MODEL_FILES.some(url => event.request.url.includes(url))) {
        event.respondWith(
            caches.match(event.request)
                .then(cached => cached || fetch(event.request))
        );
    }
});
