/*jshint esversion: 6 */
var ProductsImporter = ProductsImporter || {

	init: function () {
		window.console.log('ProductsImporter::init()');
		document.querySelector('#products-updater-button').addEventListener("click",(event)=>{
			ProductsImporter.fetchData();
		})
		ProductsImporter.spreadsheetId = window.spreadsheetId;
		ProductsImporter.apiKey= window.apiKey;
	},


	fetchData: function () {
	

		const requestURI = `https://sheets.googleapis.com/v4/spreadsheets/${ProductsImporter.spreadsheetId}/values/Sheet1?majorDimension=ROWS&key=${ProductsImporter.apiKey}`;

		window.console.log(`Fetching Google Sheets mapicle data from: ${requestURI}`);
		
		fetch(requestURI)
			.then(response => response.json())
			.then(response => {
				// Try processing the imported data.
				try {
					console.log("gsheet response" ,response)
					ProductsImporter.processData(response);
				} catch (e) {
					alert("error",e.message)
				}
				
			});
	},

	/**
	 * @throws
	 */
	processData: function (response) {
		window.console.log('Processing Google Sheets mapicle data:');

		if ('error' in response) {
			window.console.error('Response is a Google Sheets error.');
			throw `Google Sheets API Error ${response.error.code} [${response.error.status}]: ${response.error.message}`;
		}
		
		const values = response['values'];
		if (!Array.isArray(values) || values.length <= 1) {
			throw 'No data found.';
		}
		
		const headerTitles = values[0].map(h => h.trim());
		const headers = headerTitles.map(h => h.trim().toLowerCase());// Normalize headers.
		window.console.log('Collected Results data from Google Sheets import:');
		window.console.log(values)
		window.console.log("headers",headers)

						
		let counter = 1;
		
		const throttledCall = (i) => {
			if(!values[i]){
				console.log("that's all");
				document.getElementById('products-updater-status').innerHTML = `Update complete.${i-1} products processed.`;
				return;
			}
			document.getElementById('products-updater-status').innerHTML = `Processing ${i}/${values.length-1} products processed.`;
			const productValues = values[i].map(v => v.trim());
			const product = {}
			for(let i = 0; i < headers.length;i++){
				product[headers[i]] = productValues[i];
			}
				
			return new Promise((resolve, reject) => {
				setTimeout(() => {
					resolve(`resolved`);
				}, 250);
			  })
			  .then((resolve)=>{
				console.log("POST to API")
				console.log("product",product);
				return fetch("/wp-json/state-made/v1/product", {
					method: "post",
					headers: {
					  'Accept': 'application/json',
					  'Content-Type': 'application/json',
					  'X-WP-Nonce':window.productsUpdaterNonce
					},
					//make sure to serialize your JSON body
					body: JSON.stringify({
						product:product
					})
				});
			  })
			  .then(response => response.json())
			  .then((response)=>{
				console.log("response",response)
				let row = document.createElement("tr");
				row.classList.add('product-updater-row')
				row.innerHTML = `<td><strong>${response.product_posted.name}</strong></td><td>${response.success}</td>`;
				document.getElementById('products-updater-table').appendChild(row);
				document.getElementById('products-updater-table').style.display = "table";
				counter++;
				throttledCall(counter);
			  })
			  .catch((reject)=>{
				console.log("reject", reject)
				document.getElementById('products-updater-status').innerHTML = JSON.stringify(reject);
			  })
		}

		throttledCall(1);
			
		
	},
};

document.addEventListener('DOMContentLoaded', ProductsImporter.init);
