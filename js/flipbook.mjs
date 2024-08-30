import { pdfjsLib } from './pdf.mjs'; // Ajuste o caminho conforme necessário

// Function to initialize the flipbook with the given PDF file
export function openFlipbook(pdfUrl) {
    document.getElementById('flipbook-container').style.display = 'block';
    document.getElementById('lightbox').style.display = 'none';

    const flipbook = document.getElementById('flipbook');
    flipbook.innerHTML = '';

    const loadingTask = pdfjsLib.getDocument(pdfUrl);
    loadingTask.promise.then(pdf => {
        const numPages = pdf.numPages;
        let pagePromises = [];

        for (let pageNum = 1; pageNum <= numPages; pageNum++) {
            pagePromises.push(
                pdf.getPage(pageNum).then(page => {
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    const viewport = page.getViewport({ scale: 1 });
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    }).promise.then(() => {
                        const flipbookPage = document.createElement('div');
                        flipbookPage.className = 'flipbook-page';
                        flipbookPage.appendChild(canvas);
                        flipbook.appendChild(flipbookPage);

                        if (pageNum === numPages) {
                            $('#flipbook').turn({
                                width: 800,
                                height: 600,
                                autoCenter: true
                            });
                        }
                    });
                })
            );
        }

        Promise.all(pagePromises).then(() => {
            $('#flipbook').turn({
                width: 800,
                height: 600,
                autoCenter: true
            });
        });
    }).catch(err => {
        console.error('Error loading PDF: ', err);
    });
}

// Function to close the flipbook
export function closeFlipbook() {
    document.getElementById('flipbook-container').style.display = 'none';
}

// Function to close the lightbox
export function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
}

// Function to open the lightbox
export function openPDF(pdfUrl) {
    document.getElementById('lightbox').style.display = 'flex';
    document.getElementById('flipbook-container').style.display = 'none';
    document.getElementById('pdf-frame').src = pdfUrl;
}
<style>
    #flipbook-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
    }
    #flipbook {
        width: 800px;
        height: 600px;
    }
</style>
