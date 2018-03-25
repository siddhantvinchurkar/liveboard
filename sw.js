importScripts('cache-polyfill.js');

self.addEventListener('install', function(e) {
	e.waitUntil(
		caches.open('liveboard').then(function(cache) {
			return cache.addAll([
				'index.html',
				'broadcast/index.html',
				'watch/index.html',
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
			if (e.request.cache === 'only-if-cached' && e.request.mode !== 'same-origin') return;
			return response || fetch(event.request);
		})
	);
});
