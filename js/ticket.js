var slcPrint = document.getElementById("slcPrint")
const apiRouter = 'http://127.0.0.1:5656/'
const obetnerImpresoras = () => {
  PrinterEscPos.getPrinters().then(response => {
    if( response.status == "OK"){
      response.listPrinter.forEach(namePrinter => {
        const option = document.createElement("option");
        option.value = option.text = namePrinter
        slcPrint.appendChild(option)
      });
    }
  });
}
const imprimirTicket = () => {
  var impresora = PrinterEscPos(apiRouter)
  impresora.setText("Probando")
  impresora.printerIn(slcPrint)
}


obetnerImpresoras()

imprimirTicket()