<!DOCTYPE html>
<html>

<head>
  <title>PDFMake Example</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>

<body>
  <div class="outer-content">
    <h2 id="heading">PDF Page Title</h2>
    <div id="pdf-content">How to generate a pdf from the UI content description and example.</div>
    <hr>
    <button id="btn-generate">Generate PDF</button>
  </div>

  <script>
    var buttonElement = document.querySelector("#btn-generate");
    buttonElement.addEventListener('click', function () {
      var pdfHeading = document.querySelector("#heading").innerText;
      var pdfContent = document.querySelector("#pdf-content").innerText;

      // Create a canvas for the chart
      var canvas = document.createElement('canvas');
      canvas.width = 400; // Adjust canvas size as needed
      canvas.height = 400;

      // Create a pie chart
      var ctx = canvas.getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ['Red', 'Blue', 'Yellow'],
          datasets: [{
            label: '# of Votes',
            data: [12, 19, 3],
            backgroundColor: [
              'red',
              'blue',
              'yellow'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: false
        }
      });

      // Wait for the chart to fully render
      setTimeout(function () {
        // Convert the chart to an image
        var chartImage = canvas.toDataURL();

        var docDefinition = {
          content: [
            {
              text: pdfHeading,
              style: 'heading'
            },
            {
              text: pdfContent,
              style: 'vspace'
            },
            {
              image: chartImage,
              width: 400 // Adjust the width as needed
            }
          ],
          styles: {
            vspace: {
              lineHeight: 3
            },
            heading: {
              fontSize: 18,
              lineHeight: 2
            }
          }
        };
        pdfMake.createPdf(docDefinition).open();
      }, 500); // Adjust the timeout as needed
    });
  </script>
</body>

</html>