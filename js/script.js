function openPDF(pdfPath) {
  var lightbox = document.getElementById('lightbox');
  var pdfFrame = document.getElementById('pdf-frame');
  pdfFrame.src = pdfPath;  // Define o caminho do PDF no iframe
  lightbox.style.display = 'flex';  // Mostra a lightbox
}

function closeLightbox() {
  var lightbox = document.getElementById('lightbox');
  lightbox.style.display = 'none';  // Esconde a lightbox
  var pdfFrame = document.getElementById('pdf-frame');
  pdfFrame.src = '';  // Limpa o src do iframe para liberar memória
}

document.getElementById("contactForm").addEventListener("submit", function(event) {
  event.preventDefault();

  // Capturar os dados do formulário
  let name = document.getElementById("name").value;
  let email = document.getElementById("email").value;
  let phone = document.getElementById("phone").value;

  // Formatar os dados como CSV
  let csvRow = `${name},${email},${phone}\n`;

  // Salvar os dados em um arquivo CSV
  saveToCSV(csvRow);

  // Mensagem de confirmação
  document.getElementById("message").innerText = "Dados enviados com sucesso!";

  // Limpar o formulário
  document.getElementById("contactForm").reset();
});

function saveToCSV(data) {
  // Tentar recuperar o conteúdo do arquivo CSV existente ou criar um novo
  let csvFile = localStorage.getItem("contactsCSV");
  if (!csvFile) {
      // Se não houver arquivo, crie o cabeçalho
      csvFile = "Nome,Email,Telefone\n";
  }

  // Adicione os novos dados ao conteúdo do arquivo CSV
  csvFile += data;

  // Armazene o conteúdo atualizado no localStorage
  localStorage.setItem("contactsCSV", csvFile);
}

function exportCSV() {
  // Recuperar o conteúdo do CSV do localStorage
  let csvContent = localStorage.getItem("contactsCSV");
  if (!csvContent) {
      alert("Nenhum dado para exportar!");
      return;
  }

  // Criar um blob para o arquivo CSV
  let blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });

  // Criar um link para download
  let link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.setAttribute("download", "contacts.csv");

  // Clicar no link para baixar o arquivo
  link.click();
}
