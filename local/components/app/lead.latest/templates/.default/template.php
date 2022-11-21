<?php \Bitrix\Main\UI\Extension::load("ui.vue3") ?>

<div id="application" class="row row-start">

	<div class="col" v-for="value in leads">
		<h3>{{ value["TITLE"] }}</h3>
		<p class="row">Источник: <b>{{ value["SOURCE_BY_NAME"] }}</b></p>
		<p class="row">Статус: <b>{{ value["STATUS_BY_NAME"] }}</b></p>
		<p class="row">Ответственный: <b>{{ value["ASSIGNED_BY_NAME"] }}</b></p>
		<p>
			<div class="row">
				<div class="row" style="justify-content:start;">
					<input @click.prevent='(e) => UpdateCheck(e, value["ID"])' type="checkbox" checked v-if='value["UF_CHECK"] === "1"'>
					<input @click.prevent='(e) => UpdateCheck(e, value["ID"])' type="checkbox" v-else> Проверено
				</div>
				<div style="color:gray;">{{ value["DATE_CREATE"] }}</div>
			</div>
		</p>
	</div>
	
</div>

<script type="text/javascript">

	BX.Vue3.BitrixVue.createApp({
		
		data() {
			return {
				leads: <?= json_encode($arResult["leads"]); ?>
			}
		},

		methods: {

			UpdateCheck(e, id) {
				if(!confirm("Подтвердить?")) return;

				let data = (e.target.checked) ? 1 : 0;

				BX.rest.callMethod(
					"crm.lead.update",
					{
						id: id,
						fields:
						{
							"UF_CHECK": data
						}
					},
					function(result) {
						if(result.error()) {
							alert("Произошла ошибка: " + result.error());
						}

						else {
							e.target.checked = data;
							alert((data) ? "Проверено" : "Проверка убрана");
						}
					}
				);

			}

		}

	}).mount("#application");

</script>