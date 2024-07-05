
const jsonData = <?php echo json_encode($postsPerMonth); ?>


function extractCounts(data) {
    const counts = Array(12).fill(0); // Initialize an array to hold counts for each month (Jan to Dec)
    data.forEach(item => {
        counts[item.month - 1] = item.count; // Adjust index to match zero-indexed months
    });
    return counts;
}

const countsPerMonth = extractCounts(jsonData);

const configChartOptionsExample = {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
        datasets: [{
            label: 'Number of posts per month',
            data: countsPerMonth,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',   // January
                'rgba(54, 162, 235, 0.2)',   // February
                'rgba(255, 206, 86, 0.2)',   // March
                'rgba(75, 192, 192, 0.2)',   // April
                'rgba(153, 102, 255, 0.2)',  // May
                'rgba(255, 159, 64, 0.2)',   // June
                'rgba(255, 99, 132, 0.4)',   // July
                'rgba(54, 162, 235, 0.4)',   // August
                'rgba(255, 206, 86, 0.4)',   // September
                'rgba(75, 192, 192, 0.4)',   // October
                'rgba(153, 102, 255, 0.4)',  // November
                'rgba(255, 159, 64, 0.4)'    // December
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',   // January
                'rgba(54, 162, 235, 1)',   // February
                'rgba(255, 206, 86, 1)',   // March
                'rgba(75, 192, 192, 1)',   // April
                'rgba(153, 102, 255, 1)',  // May
                'rgba(255, 159, 64, 1)',   // June
                'rgba(255, 99, 132, 1)',   // July
                'rgba(54, 162, 235, 1)',   // August
                'rgba(255, 206, 86, 1)',   // September
                'rgba(75, 192, 192, 1)',   // October
                'rgba(153, 102, 255, 1)',  // November
                'rgba(255, 159, 64, 1)'    // December
            ],
            borderWidth: 1,
        }]
    },
    options: {
        scales: {
            x: {
                ticks: {
                    color: '#4285F4',
                },
            },
            y: {
                ticks: {
                    color: '#f44242',
                    stepSize: 5,
                    beginAtZero: true,
                },
            },
        },
    },
};

// Initialize Chart
new Chart(
    document.getElementById('chart-options-example'),
    configChartOptionsExample
);
