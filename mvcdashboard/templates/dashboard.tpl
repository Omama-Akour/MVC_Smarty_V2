{* views/dashboard.tpl *}

{extends file="layouts/app.tpl"}

{block name=title}Dashboard{/block}

{block name=contents}
    <div class="container">
        <h1 class="mb-3">Dashboard</h1>

        {* Display the pie chart *}
        <div class="mb-4">
            {* Include Chart.js from CDN *}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            {* Create a canvas element for the chart *}
            <canvas id="categoryContentChart" width="400" height="400"></canvas>

            {* Script to initialize and configure the chart *}
            <script>
                // Data for the chart (replace these values with your actual counts)
                var data = {
                    labels: ['Categories', 'Contents'],
                    datasets: [{
                        data: [{$categoryCount}, {$contentCount}],
                        backgroundColor: ['#36a2eb', '#ff6384']
                    }]
                };

                // Get the canvas element
                var ctx = document.getElementById('categoryContentChart').getContext('2d');

                // Create the pie chart
                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            position: 'top',
                        },
                    },
                });
            </script>
        </div>

        {* Add other content of your dashboard here *}

    </div>
{/block}
