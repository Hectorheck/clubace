/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
	apiKey: "AIzaSyCPW9OPomsK8tQCTP59_QV_RwONwen_bSc",
	authDomain: "ace-test-81900.firebaseapp.com",
	projectId: "ace-test-81900",
	storageBucket: "ace-test-81900.appspot.com",
	messagingSenderId: "728374216419",
	appId: "1:728374216419:web:b3bab21f894826ae57a7d6",
	measurementId: "G-YW4M5HE1Z1"
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
	console.log(
		"[firebase-messaging-sw.js] Received background message ",
		payload,
	);
	/* Customize notification here */
	const notificationTitle = "Background Message Title";
	const notificationOptions = {
		body: "Background Message body.",
		icon: "/itwonders-web-logo.png",
	};

	return self.registration.showNotification(
		notificationTitle,
		notificationOptions,
	);
});