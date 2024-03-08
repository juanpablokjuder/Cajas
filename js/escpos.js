class PrinterEscPos {
  constructor(apiPath){
      this.apiRouter = apiPath;
      this.dataPrinter = [];
  }
  static getPrinters = (apiPath="http://127.0.0.1:5656/")=> {
      return $.ajax({
          type: "GET",
          url: apiPath+"printers",
          async:false,
          contentType:"application/json",
          success: function (response) {
              if(response.status == "OK"){
                  console.log("success");
              }else if(response.status == "ERROR"){
                  console.log("error: "+response.error);
              }
          }
      });
  };
  setText = (text) => {
      var data = {
          type:"text",
          data:text +"\n"
      };
      this.dataPrinter.push(data);
  };
  openCash = () =>{
      var data = {
          type:"openpartial"
      };
      this.dataPrinter.push(data);
  };
  openCashPartial = () =>{
      var data = {
          type:"open"
      };
      this.dataPrinter.push(data);
  };
  setImage = (image) =>{
      var data = {
          type:"image",
          data:image
      };
      this.dataPrinter.push(data);
  };
  setQR = (qrDigits)=>{
      var data = {
          type:"qr",
          data:qrDigits
      };
      this.dataPrinter.push(data);
  };
  setImage = (pathImage,width = 600,height=200) =>{
      var data = {
          type:"img",
          data:pathImage,
          width:width,
          height:height
      };
      this.dataPrinter.push(data);
  };
  setConfigure = (align = "left",font="a",bold=false) => {
      var data = {
          type:"configure",
          align:align,
          typeFont:font,
          bold:bold
      };
      this.dataPrinter.push(data);
  };
  setBarCode = (code,typeBarCode = "CODE93") =>{
      var data = {
          type:"barcode",
          data:code,
          typeCode:typeBarCode
      };
      this.dataPrinter.push(data);
  };
  printerIn = (namePrinter) =>{
      return $.ajax({
          type: "POST",
          url: this.apiRouter+"command/" + namePrinter,
          data: JSON.stringify(this.dataPrinter),
          dataType: "json",
          success: function (response) {
              if(response.status == "OK"){
                  console.log("success");
              }else if(response.status == "ERROR"){
                  console.log("error: "+response.error);
              }
              this.dataPrinter = [];
          },error: error =>{
              console.log("error con el servidor");
              console.log(error);
              this.dataPrinter = [];
          }
      });
  };

}