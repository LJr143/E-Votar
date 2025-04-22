import './bootstrap';
import "./packages/simple-notify";
import  "./echo.js";


window.Echo.channel('table-updates').listen('TableUpdated', (event) => {
    console.log('TableUpdated event received:', event);
});
