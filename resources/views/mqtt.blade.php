<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQTT Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart" width="400" height="200"></canvas>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Data from MQTT',
                    data: [],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function fetchData() {
            fetch('/path/to/your/csv/data.csv') // Ganti dengan path yang sesuai
                .then(response => response.text())
                .then(data => {
                    const lines = data.split('\n');
                    const latestData = lines[lines.length - 2].split(','); // Ambil data terbaru
                    const timestamp = new Date().toLocaleTimeString();

                    myChart.data.labels.push(timestamp);
                    myChart.data.datasets[0].data.push(latestData[0]); // Ambil nilai dari CSV
                    myChart.update();
                });
        }

        setInterval(fetchData, 2000); // Ambil data setiap 2 detik
    </script>
</body>
</html>