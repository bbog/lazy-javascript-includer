

lazyRequest = (function () {

		var xhr = new XMLHttpRequest();

		return function (method, url, callback, isXML) {
			xhr.onreadystatechange = function() {
				if ( xhr.readyState === 4 ) {
					if (isXML) {
						callback(xhr.responseXML);
					} else {
						callback(xhr.responseText);
					}
				}
			};
			xhr.open(method, url, false);
			xhr.send();
		}

	})();


lazyRequest('get', 'lazyInclude.php', function (data) {
		document.write(data);
}, false);
