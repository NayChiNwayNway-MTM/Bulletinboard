@extends('layouts.nav')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.5.0/dist/css/coreui.min.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Bootstrap CSS (optional, for better layout) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{asset('/css/chart.css')}}">
</head>
@section('content')
<section class="background mt-5">
  <div class="container margin">
    <div class="row">
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
            <div class="text-primary fs-5 fw-semibold mb-2">Number of Users</div>
              <div class="fs-4 fw-semibold mb-5">{{$users}}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
            <div class="text-primary fs-5 fw-semibold mb-2">Number of all Posts</div>
              <div class="fs-4 fw-semibold  mb-5">{{$posts}}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
            <div class="text-primary fs-5 fw-semibold mb-2">Number of active posts</div>
              <div class="fs-4 fw-semibold  mb-5">{{$active}}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
            <div class="text-primary fs-5 fw-semibold mb-2">Number of inactive posts</div>
              <div class="fs-4 fw-semibold  mb-5">{{$inactive}}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container d-flex justify-content-center align-items-center">
    <div id="chart-container">
          <canvas id="chart-options-example"></canvas>
    </div>
    <div class="mx-3">
    <canvas id="userActivityChart" width="50px" height="50px"></canvas>
    </div>
  </div>
 
  

  
  <img src="{{asset('uploads/page_top.png')}}" alt="pagetop" class="pagetop" id="scrolltop">
</section>
  <!-- Bootstrap JS (optional, for dropdown) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <!-- CoreUI JS (if needed) -->
  <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.5.0/dist/js/coreui.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  
  
  <script>
    //stat page top
        function scrollToTop(){
          window.scrollTo({
            top:0,
            behavior:'smooth'
          });
        }
        window.onscroll = function(){scrollfunction();}
        function scrollfunction(){
            if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20){
              document.getElementById('scrolltop').style.display = 'block'
            }
            else{
              document.getElementById('scrolltop').style.display='none'
            }
        }
    
   
        //end page top

        //start barchart
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
    //end barchart

    //start for doughnut chart
      const jsonuserdata = <?php echo json_encode($userActivity);?>;
   
      const labels = jsonuserdata.map(user => user.name);
      const data = jsonuserdata.map(user => user.post_count);
      const backgroundColors = generateDynamicColors(labels.length);
      const hoverBackgroundColors = backgroundColors.map(color => lightenColor(color, 20));
      const doughnutChart = new Chart(document.getElementById('userActivityChart'), {
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            data:data,
            backgroundColor: backgroundColors,
            hoverBackgroundColor: hoverBackgroundColors
          }]
        },
        options: {
          responsive: true
        }
      })
      function generateDynamicColors(numColors) {
                const colors = [];
                for (let i = 0; i < numColors; i++) {
                    const color = `hsl(${Math.floor(Math.random() * 360)}, 70%, 50%)`;
                    colors.push(color);
                }
                return colors;
      }
      // Function to lighten a color
      function lightenColor(color, percent) {
        const num = parseInt(color.slice(1), 16),
        amt = Math.round(2.55 * percent),
        R = (num >> 16) + amt,
        G = (num >> 8 & 0x00FF) + amt,
        B = (num & 0x0000FF) + amt;
        return `#${(0x1000000 + (R < 255 ? R < 1 ? 0 : R : 255) * 0x10000 + (G < 255 ? G < 1 ? 0 : G : 255) * 0x100 + (B < 255 ? B < 1 ? 0 : B : 255)).toString(16).slice(1).toUpperCase()}`;
      }
    //end for doughnut chart
  </script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection