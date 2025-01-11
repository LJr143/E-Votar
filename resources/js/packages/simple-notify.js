import Notify from 'simple-notify';
import 'simple-notify/dist/simple-notify.css';

window.Notify = Notify;

window.pushNotification = function (status, title, text) {
    new Notify({
        status: status,
        title: title,
        text: text,
        effect: 'fade',
        speed: 300,
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 10000,
        gap: 20,
        distance: 20,
        type: 'outline',
        position: 'right top',
    });
}

