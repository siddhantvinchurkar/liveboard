importScripts('cache-polyfill.js');

self.addEventListener('install', function(e) {
	e.waitUntil(
		caches.open('liveboard').then(function(cache) {
			return cache.addAll([
				'index.php',
				'broadcast/index.php',
				'watch/index.php',
				'images/logo.png',
				'images/logo192.png',
				'css/materialize.min.css',
				'manifest.json',
				'js/materialize.min.js'
			]);
		})
	);
});

self.addEventListener('fetch', function(event) {
	console.log(event.request.url);
	event.respondWith(
		caches.match(event.request).then(function(response) {
			return response || fetch(event.request);
		})
	);
});
