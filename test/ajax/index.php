<?php 
	$include = include_once($_SERVER["DOCUMENT_ROOT"] . "/local/include.php");
	require($_SERVER["DOCUMENT_ROOT"] . $include["header"]);

	echo "<pre>";
	var_dump($_REQUEST);
	var_dump($_SERVER);
	echo "</pre>";
?>

<script type="text/javascript">

	// BxGet();
	// BxPost();
	// BxAjaxGet();
	// BxAjaxPost();
	// FetchGet();
	FetchPost();

	async function FetchGet() {
		let result = await fetch("/app/lead?action=test&method=GET&name=Fetch GET test", {
			headers: {
				"Bx-Ajax": true,
				"X-Requested-With": "XMLHttpRequest",
			}
		});
		result = await result.json();
		console.log(result);
	}

	async function FetchPost() {
		let formData = new FormData();
		formData.append("method", "POST");
		formData.append("name", "Fetch POST test");

		let object = {
			"method": "POST",
			"name": "Fetch POST test",
		};

		let JSONstringify = JSON.stringify(object);

		let result = await fetch("/app/lead?action=test", {
			method: "POST",
			headers: {
				"Bx-Ajax": true,
				"X-Requested-With": "XMLHttpRequest",
				// "Content-Type": "application/x-www-form-urlencoded",
				// "Content-Type": "multipart/form-data",
				"Content-Type": "application/json",
			},
			// body: formData,
			// body: object,
			body: JSONstringify,

		});
		result = await result.json();
		console.log(result);
	}

	function BxAjaxGet() {
		BX.ajax({
			url: "/app/lead?action=test",
			method: "GET",
			data: { "method": "GET", "name": "BX Ajax GET test" },
			cache: false,
			onsuccess: function(data) {
				console.log(JSON.parse(data));
			},
			onfailure: function(err) {
				console.log(err);
			}
		});
	}

	function BxAjaxPost() {
		BX.ajax({
			url: "/app/lead?action=test",
			method: "POST",
			data: { "method": "POST", "name": "BX Ajax POST test" },
			processData: true,
			start: true,
			cache: false,
			onsuccess: function(data) {
				console.log(JSON.parse(data));
			},
			onfailure: function(err) {
				console.log(err);
			}
		});
	}
	
	function BxGet() {
		BX.ajax.get(
			`/app/lead?action=test`,
			{"method": "GET", "name": "BX GET test"},
			function(result) {
				console.log(JSON.parse(result));
			}
		);	
	}
	
	function BxPost() {
		BX.ajax.post(
			`/app/lead?action=test`,
			{"method": "POST", "name": "BX POST test"},
			function(result) {
				console.log(JSON.parse(result));
			}
		);	
	}

</script>

<?php require($_SERVER["DOCUMENT_ROOT"] . $include["footer"]); ?>