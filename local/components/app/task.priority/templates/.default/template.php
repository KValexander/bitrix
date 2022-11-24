<?php \Bitrix\Main\UI\Extension::load("ui.vue3") ?>

<div id="application">

	<!-- Последние активные задачи -->
	<!-- :key почему-то не работает -->
	<div class="row row-start">
		<div class="col" v-for="value in tasks" :key='value["UF_PRIORITY"]'>
			<h3>{{ value["TITLE"] }}</h3>
			<p class="row">Ответственный: <b>{{ value["RESPONSIBLE_NAME"] }}</b></p>
			<p class="row">Постановщик: <b>{{ value["CREATED_BY_NAME"] }}</b></p>
			<p class="row">Дата постановки:
				<p v-if='value["START_DATE_PLAN"]'><b>{{ value["START_DATE_PLAN"] }} - {{ value["END_DATE_PLAN"] }}</b></p>
				<b v-else>Без срока</b>
			</p>
			<div class="row">
				<p>Приоритет:</p>
				<div class="row">
					<button @click.prevent='(e) => UpdateTaskPriority(e, value["ID"], false)'>-</button>
					<span id="priority">{{ value["UF_PRIORITY"] }}</span>
					<button @click.prevent='(e) => UpdateTaskPriority(e, value["ID"], true)'>+</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Последняя история изменений -->
	<h2>Последняя история изменений</h2>
	<table class="history">
		<tr>
			<th>Название задачи</th>
			<th>Старый приоритет</th>
			<th>Новый приоритет</th>
			<th>Редактор</th>
			<th>Дата изменения</th>
		</tr>
		<tr v-for="value in history">
			<td>{{ value["TITLE"] }}</td>
			<td>{{ value["UF_OLD_PRIORITY"] }}</td>
			<td>{{ value["UF_NEW_PRIORITY"] }}</td>
			<td>{{ value["NAME"] }}</td>
			<td>{{ value["UF_DATE_CREATE"] }}</td>
		</tr>
	</table>
	
</div>

<script type="text/javascript">

	BX.Vue3.BitrixVue.createApp({

		data() {
			return {
				tasks: <?= json_encode($arResult["tasks"]); ?>,
				history: <?= json_encode($arResult["history"]); ?>,
				userId: <?= json_encode($arResult["userId"]); ?>,
			}
		},

		methods: {

			UpdateTaskPriority(e, id, bool) {
				let self = this, priority, p;
				priority = e.target.parentNode.querySelector("#priority");
				p = priority.innerHTML;
				
				BX.ajax.post(
					"/app/task/?action=updateTask",
					{ "ID": id, "UF_PRIORITY": (bool) ? ++p : --p },
					function(result) {
						self.UploadTaskPriorityHistory(id, priority.innerHTML, p);
						priority.innerHTML = p;
						self.tasks.find(task => task["ID"] == id)["UF_PRIORITY"] = p;
						self.tasks.sort((a, b) => b["UF_PRIORITY"] - a["UF_PRIORITY"]);
					}
				);
			},

			UploadTaskPriorityHistory(taskId, old, n) {
				let self = this;
				BX.ajax.post(
					"/app/task/?action=addTaskPriorityHistory",
					{
						"TASK_ID": taskId,
						"USER_ID": self.userId,
						"OLD": old,
						"NEW": n,
					},
					function(result) {
						BX.ajax.get(
							"/app/task?action=getTaskPriorityHistory",
							function(res) {
								self.history = JSON.parse(res);
							}
						);
					}
				);
			}

		}

	}).mount("#application");

</script>