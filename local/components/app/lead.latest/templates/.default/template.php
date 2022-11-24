<?php \Bitrix\Main\UI\Extension::load("ui.vue3"); ?>

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

	/* Vue create app */
	BX.Vue3.BitrixVue.createApp({
		
		/* Return data */
		data() {
			return {
				leads: <?= json_encode($arResult["leads"]); ?>
			}
		},

		/* Methods */
		methods: {

			/* Update check */
			async UpdateCheck(e, id) {
				if(!confirm("Подтвердить?")) return;
				let check = (e.target.checked) ? 1 : 0;

				/* Ajax */
				BX.ajax.post(
					`/app/lead/?action=updateLead`,
					{ "ID": id, "UF_CHECK": check },
					function(result) {
						e.target.checked = check;
						alert((check) ? "Проверено" : "Проверка убрана");
					}
				);

			}

		}

	/* Mount */
	}).mount("#application");

</script>