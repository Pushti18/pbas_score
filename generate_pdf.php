<!DOCTYPE html>
<html>

<head>
    <title>PDFMake Example</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.min.js"></script>
</head>

<body>
    <div class="outer-content">
        <h2 id="heading">PDF Page Title</h2>
        <div id="pdf-content">How to generate a pdf from the UI content description and example.
        </div>
        <!-- <img src="cherry.jpeg" id="image-preview" /> -->
        <hr>
        <button id="btn-generate">Generate PDF</button>
    </div>

    <script>
        var buttonElement = document.querySelector("#btn-generate");
        buttonElement.addEventListener('click', function () {
            var pdfHeading = document.querySelector("#heading").innerText;
            var pdfContent = document.querySelector("#pdf-content").innerText;
            var pdfImage = getDataUrl(document.querySelector("#image-preview"));
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
                        image: pdfImage
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
        });

        function getDataUrl(imgSource) {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            // canvas.width = imgSource.width;
            // canvas.height = imgSource.height;
            // context.drawImage(imgSource, 0, 0);
            return canvas.toDataURL('image/jpeg');
        }
    </script>
</body>

</html>