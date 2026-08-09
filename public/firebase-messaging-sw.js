importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.8.0/firebase-messaging-compat.js');

const firebaseConfig = {
    apiKey: "AIzaSyDmKeP3bqBfDYet_usW46t89IxoQds-DdA",
    authDomain: "task-management-c3bff.firebaseapp.com",
    projectId: "task-management-c3bff",
    storageBucket: "task-management-c3bff.firebasestorage.app",
    messagingSenderId: "731879977881",
    appId: "1:731879977881:web:53e7b1f5aae69734539908",
    measurementId: "G-HXDX8LDZ61"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message (disabled system popup)', payload);
});
