<!DOCTYPE html>
<html>

<head>
	<title>Bitcoin Price Graph</title>
	<link rel="stylesheet" type="text/css"
		href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<style>
	body {
		background: rgb(33, 55, 5);
		background: linear-gradient(90deg, rgba(33, 55, 5, 1) 0%, rgba(235, 235, 18, 1) 100%);
	}
	div #but{
		background-color: #213705;
		color: white;
  		border: none;
		padding: 10px;
		border-radius: 5px;
	}
	div #but:hover {
		background-color: #EBEB12;
		color: black;
		cursor: pointer;
	}
	/* Media queries for mobile devices */
	@media only screen and (max-width: 600px) {
			h1 {
				font-size: 24px;
			}

			input[type="text"] {
				max-width: 100%;
			}

			#chart canvas {
				max-width: 100%;
			}
		}
</style>

<body>
	<div class="container mt-5">
		<div style="background-color: #fff; padding: 10px; border-radius: 10px;">
			<h1 style="justify-content: center;display: flex;">
				Bitcoin Price Graph</h1>
			<form id="symbolForm" class="mt-3">
				<div class="form-group">
					<label for="symbols">Enter Bitcoin Symbols (<span style="color:red;">comma-separated( ,
							)</span>)</label>
					<input style="max-width: 45%; border-color: black;" type="text" class="form-control" id="symbols"
						name="symbols" placeholder="BTC,WBTC,PAXG">
				</div>
				<button id="but" type="submit" class="btn btn-primary">Get Price</button>
			</form>
		</div>
		<div id="chart" class="mt-5">
			<canvas style="max-width: 80%;" id="priceChart"></canvas>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
	<script>
		$(function () {
			$('#symbolForm').submit(function (event) {
				event.preventDefault();
				var sty = document.getElementById("chart");
				sty.style.backgroundColor = "#fff";
				sty.style.padding = "10px";
				sty.style.marginBottom = "25px";
				sty.style.borderRadius = "10px";
				var symbols = $('#symbols').val().trim().toUpperCase();
				var symbolArray = symbols.split(',');
				var symbolString = symbolArray.join(',');
				var apiUrl = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
				var apiKey = '29366e8f-d165-48fb-94c2-e36c5b79d456';
				var requestData = {
					'symbol': symbolString,
					'convert': 'INR'
				};
				var regex = /^[A-Z]+(,[A-Z]+)*$/;
				if (!regex.test(symbols)) {
					alert('Please enter valid symbols separated by commas ( , )');
					return;
				}
				$.ajax({
					url: 'api.php',
					type: 'POST',
					data: requestData,
					dataType: 'json',
					success: function (response) {
						var data = [];
						for (var i = 0; i < symbolArray.length; i++) {
							var symbol = symbolArray[i];
							if (!response.data.hasOwnProperty(symbol)) {
								alert('Invalid Coin Symbol: ' + symbol);
								return;
							}
							var price = response.data[symbol].quote.INR.price;
							data.push({
								label: symbol,
								data: [price],
								backgroundColor: getRandomColor()
							});
						}
						renderChart(data);
					},
					error: function (error) {
						console.log(error);
					}
				});
			});
		});

		function renderChart(data) {
			var ctx = document.getElementById('priceChart').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					datasets: data
				},
				options: {
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true
							},
							scaleLabel: {
								display: true,
								labelString: '----> Coin Price in (INR)',
								fontFamily: 'Arial',
        						fontSize: 14,
								fontWeignt: 'Bold'
							}
						}],
						xAxes: [{
							scaleLabel: {
								display: true,
								labelString: '----> Name of the Coins',
								fontFamily: 'Arial',
        						fontSize: 14,
								fontWeignt: 'Bold'
							}
						}]
					}
				}
			});
		}

		function getRandomColor() {
			var letters = '0123456789ABCDEF';
			var color = '#';
			for (var i = 0; i < 6; i++) {
				color += letters[Math.floor(Math.random() * 16)];
			}
			return color;
		}

	</script>
</body>

</html>