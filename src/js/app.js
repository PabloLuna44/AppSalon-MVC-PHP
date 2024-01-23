let paso = 1;
const pasoInicial = 1;
const pasoFInal = 3;

const cita = {
  id:"",
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};

document.addEventListener("DOMContentLoaded", function () {
  startApp();
});

function startApp() {


  DisplaySection(); //Muestra y oculta las secciones
  tabs(); //Cambia la seccion cuando se presionen los tabs
  buttonsPagination(); //Muestra los botones para la paginacion
  nextPage(); //Cambia a la siguiente pagina
  previousPage(); //Cambia a la pagina previa

  queryAPI(); //Consulra la API en el backend en PHP
  nameCustomer(); //Añade el nombre del cliente al objeto de cita
  idCustomer();
  selectDate(); //Añade la fecha de la cita al objeto de cita
  selectTime(); //Añade la hora de la cta al objeto
  
}

function tabs() {
  const buttons = document.querySelectorAll(".tabs button");

  buttons.forEach((button) => {
    button.addEventListener("click", function (e) {
      //con el evento se lee el paso seleccionado
      paso = parseInt(e.target.dataset.paso);

      DisplaySection();
      buttonsPagination();
    });
  });
}

function DisplaySection() {
  //Ocultar la seccion que tenga la clse de mostrar

  const previousSection = document.querySelector(".display");
  if (previousSection) {
    previousSection.classList.remove("display");
  }
  //Selecionar la seccion con el paso...
  const section = document.querySelector(`#paso-${paso}`);
  section.classList.add("display");

  //Quita la clase de actual al anterior

  const previousTab = document.querySelector(".current");
  if (previousTab) {
    previousTab.classList.remove("current");
  }

  //Resalta el tab actual
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add("current");
}

function buttonsPagination() {
  const nextPage = document.querySelector("#next");
  const previousPage = document.querySelector("#previous");

  if (paso === 1) {
    nextPage.classList.remove("hide");
    previousPage.classList.add("hide");
  } else if (paso === 3) {
    previousPage.classList.remove("hide");
    nextPage.classList.add("hide");
    //Muestra el resumen cunado este en ese paso
    displaySummary();
  } else {
    previousPage.classList.remove("hide");
    nextPage.classList.remove("hide");
  }

  DisplaySection();
}

function nextPage() {
  const nextPage = document.querySelector("#next");

  nextPage.addEventListener("click", function () {
    if (paso >= pasoFInal) return;

    paso++;

    buttonsPagination();
  });
}

function previousPage() {
  const nextPage = document.querySelector("#previous");

  nextPage.addEventListener("click", function () {
    if (paso <= pasoInicial) return;

    paso--;

    buttonsPagination();
  });
}

async function queryAPI() {
  try {
    //Intenta realizar lo dentro de try si no muestra el error
    //Ya que si hay un errore javascript deja de funciornar con el try cacth se sigue ejecutando
    const url = `${location.origin}/api/services`;
    //Await espera hasta que se descarguen todlo lo de la url
    const result = await fetch(url);
    const services = await result.json();

    //Manda a llamar a la funcion para mostrar todos lo servicios
    DisplayServices(services);
  } catch (error) {
    // console.log(error);
  }
}

function DisplayServices(services) {
  services.forEach((service) => {
    const { id, nombre, precio } = service;

    const nameService = document.createElement("P");
    nameService.classList.add("name-service");
    nameService.textContent = nombre;

    const priceService = document.createElement("P");
    priceService.classList.add("price-service");
    priceService.textContent = `$${precio}`;

    const serviceDiv = document.createElement("DIV");
    serviceDiv.classList.add("service");
    serviceDiv.dataset.idServicio = id;
    serviceDiv.onclick = function () {
      SelectionService(service);
    };

    serviceDiv.appendChild(nameService);
    serviceDiv.appendChild(priceService);

    document.querySelector("#servicios").appendChild(serviceDiv);
  });
}

function SelectionService(service) {
  const { id } = service;
  const { servicios } = cita; //Extrae el atributo de sercvicio del objeto
  const divService = document.querySelector(`[data-id-servicio="${id}"]`);

  //Comprobar si servicio ya fue agregado
  if (servicios.some((agregado) => agregado.id === id)) {
    //Filtra los servicios que no sean el que se va a
    cita.servicios = servicios.filter((agregado) => agregado.id != id);

    divService.classList.remove("selected");
  } else {
    cita.servicios = [...servicios, service]; //Hace una copia de servicios y le agrega el nuevo  servicio

    divService.classList.add("selected");
  }
}

function idCustomer(){
  cita.id=document.querySelector('#id').value;
}

function nameCustomer() {
  cita.nombre = document.querySelector("#nombre").value;
}

function selectDate() {
  const inputDate = document.querySelector("#fecha");

  inputDate.addEventListener("input", function (event) {
    //getUTCDate retorna un numero dependiendo del dia de la semana
    const dia = new Date(event.target.value).getUTCDay();

    // si el dia es domingo muestra la alerta
    if ([0].includes(dia)) {
      event.target.value = "";
      // console.log("los domingos no abrimos");
      displayAlert("Los domingos no permitidos", "error", ".form");
    } else {
      cita.fecha = event.target.value;
    }

    cita.fecha = inputDate.value;
  });
}

function selectTime() {
  const inputTime = document.querySelector("#hora");

  inputTime.addEventListener("input", function (event) {
    const timeDate = event.target.value;
    //split hace la crea una array depende de la divisio que pasemos
    const time = timeDate.split(":")[0];

    if (time < 10 || time > 20) {
      event.target.value = "";
      displayAlert("Hora seleccionada no valida", "error", ".form");
    } else {
      cita.hora = event.target.value;
    }
  });
}

function displayAlert(mesage, type, elemento, desaparece = true) {
  //Previene que se genere mas de una alerta
  const previousAlert = document.querySelector(".alert");
  if (previousAlert) {
    previousAlert.remove(".alert");
  }

  //Crea el elemeto div
  const alert = document.createElement("DIV");

  //Agrega el contenido de mensaje y las clases
  alert.textContent = mesage;
  alert.classList.add("alert");
  alert.classList.add(type);

  //Selecciona elemento form
  const reference = document.querySelector(elemento);
  reference.appendChild(alert); //agrega la alerta

  if (desaparece) {
    setTimeout(() => {
      alert.remove();
    }, 3000);
  }
}

function displaySummary() {
  const summary = document.querySelector(".summary-content");

  //Limpiar el contenido del resumen
  while (summary.firstChild) {
    summary.removeChild(summary.firstChild);
  }

  //Verifica que los valores en cita no esten vacios y que tenga seleccionado almenos un servicio
  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    displayAlert(
      "Hacen falta completar datos o elegir un servicio",
      "error",
      ".summary-content",
      false
    );

    return;
  }

  //Formatear el div de resumen
  const { nombre, fecha, hora, servicios } = cita;

  const nameCustomer = document.createElement("P");
  nameCustomer.innerHTML = `<span>Nombre: </span>${nombre}`;

  //Formatear la fecha
  const dateObj= new Date(fecha);
 
  const dateUTC =new Date(Date.UTC(dateObj.getUTCFullYear(),dateObj.getMonth(),dateObj.getDate()+2))

  //opciones para mostrar la fecha
  const options={weekday:'long',year:'numeric',month:'long',day:'numeric'}
  const formattedDate=dateUTC.toLocaleDateString('es-MX',options);

  const date = document.createElement("P");
  date.innerHTML = `<span>Fecha: </span>${formattedDate}`;

  const time = document.createElement("P");
  time.innerHTML = `<span>Hora: </span>${hora}`;
 
//Heading para servicios
const headingInformation=document.createElement('H3');
headingInformation.textContent="Informacion de la cita";
summary.appendChild(headingInformation);

  //Mostrar los datos de usuario
  summary.appendChild(nameCustomer);
  summary.appendChild(date);
  summary.appendChild(time);

//Heading para servicios
const headingServices=document.createElement('H3');
headingServices.textContent="Resumen de servicios";
summary.appendChild(headingServices);


  //iterando y mostrando los servicios 
  servicios.forEach((service) => {
    const { id, nombre, precio } = service;
    const serviceContainer = document.createElement("DIV");
    serviceContainer.classList.add("service-container");

    const textService = document.createElement("P");
    textService.textContent = nombre;

    const priceService = document.createElement("P");
    priceService.innerHTML=`<span>Precio: </span>${precio}`;

    serviceContainer.appendChild(textService);
    serviceContainer.appendChild(priceService);
    summary.appendChild(serviceContainer);
  });

  //boton para crear una cita
  const buttonReserve=document.createElement('BUTTON');
  buttonReserve.classList.add('button');
  buttonReserve.textContent='Reservar Cita';
  buttonReserve.onclick=reserveDate;

  summary.appendChild(buttonReserve);

  
}


async function reserveDate(){
 
  const {id,nombre,fecha,hora,servicios}=cita;
  const idServicio=servicios.map(servicio=>servicio.id);

  

  const data=new FormData();
  data.append('nombre',nombre);
  data.append('fecha',fecha);
  data.append('hora',hora);
  data.append('usuarioId',id);
  data.append('servicios',idServicio);

  // console.log([...data]);


try{

 //Peticio hacia la API
 const url=`${location.origin}/api/citas`;

 const respuesta= await fetch(url,{
  method: 'POST',
  body:data
 });

 const resultado= await respuesta.json();
// console.log(resultado);


 if(resultado.resultado){
  Swal.fire({
    title: 'Cita creada',
    text: 'Tu cita fue creada correctamente',
    icon: 'success',
		button: 'OK'

  }).then(()=>{
    window.location.reload();
  });
 }

}catch(error){
  
  Swal.fire({
    title: 'Error',
    text: 'Hubo un error',
    icon: 'error',
		button: 'OK'

  });
}


  

}


