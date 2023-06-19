<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo; ?></h2>
    <p class="registro__descripcion">Elige tu plan</p>

    <div class="paquetes__grid">
        <div class="paquete">
            <h3 class="paquete__nombre">Pase Gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a Eventos de Boletomania</li>
            </ul>

            <p class="paquete__precio">$0</p>

            <form method="POST" action="/finalizar-registro/gratis">
                <input class="paquetes__submit" type="submit" value="Inscripción Gratis">
            </form>
        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">Pase Vip</h3>
            <ul class="paquete__lista">
            <li class="paquete__elemento">Acceso Presencial a Boletomania</li>
                
                <li class="paquete__elemento">Acceso a festivales y conciertos</li>
                <li class="paquete__elemento">Acceso a las grabaciones</li>
                <li class="paquete__elemento">Camisa del Evento</li>
                <li class="paquete__elemento">Comida y Bebida</li>
            </ul>

            <p class="paquete__precio">$199</p>

            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                </div>
            </div>

        </div>

        <div class="paquete">
            <h3 class="paquete__nombre">Pase General</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a Boletomania</li>
                <li class="paquete__elemento">Acceso a los en vivos</li>
                <li class="paquete__elemento">Acceso a festivales y conciertos</li>
                <li class="paquete__elemento">Acceso a las grabaciones</li>
            </ul>

            <p class="paquete__precio">$49</p>
            <div id="smart-button-container">
                <div style="text-align: center;">
                    <div id="paypal-button-container-general"></div>
                </div>
            </div>
        </div>
    </div>

</main>



<script src="https://www.paypal.com/sdk/js?client-id=ARgWV1VeMFaolZ_7HXxPiG-Ve51R7HZUkGVV8THiH88k2tVfl0s4dbtCy8OxousYxF9FB07LwJskplqv" data-sdk-integration-source="button-factory"></script>

<script>
function initPayPalButton() {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },
 
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"1","amount":{"currency_code":"USD","value":199}}]
          });
        },
 
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
 
            const datos = new FormData();
            datos.append('paquete_id', orderData.purchase_units[0].description);
            datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);
            
            fetch('/finalizar-registro/pagar', {
                method: 'POST',
                body: datos
            })
            .then( respuesta => respuesta.json())
            .then( resultado => {
                if(resultado.resultado) {
                    actions.redirect('http://localhost:3000/finalizar-registro/conciertos');
                }
            })

          });
        },
 
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
      //Pase General
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'pay',
        },
 
        createOrder: function(data, actions) {
          return actions.order.create({
            purchase_units: [{"description":"2","amount":{"currency_code":"USD","value":49}}]
          });
        },
 
        onApprove: function(data, actions) {
          return actions.order.capture().then(function(orderData) {
 
            const datos = new FormData();
            datos.append('paquete_id', orderData.purchase_units[0].description);
            datos.append('pago_id', orderData.purchase_units[0].payments.captures[0].id);
            
            fetch('/finalizar-registro/pagar', {
                method: 'POST',
                body: datos
            })
            .then( respuesta => respuesta.json())
            .then( resultado => {
                if(resultado.resultado) {
                    actions.redirect('http://localhost:3000/finalizar-registro/conciertos');
                }
            })

          });
        },
 
        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container-general');




    }
 
  initPayPalButton();
</script>
