{if !isset($IS_ASSIGNMENT_UPDATE)}
	{assign "IS_ASSIGNMENT_UPDATE" 0}
{/if}

<div class="panel panel-primary">
	{if $IS_ASSIGNMENT_UPDATE != 1}
	<div class="panel-heading">
		<h3 class="panel-title">
			{#courseAssignmentNew#}
		</h3>
	</div>
	{/if}
	<div class="panel-body">
		<form class="new_course_assignment_form">
				<div class="row">
					<div class="form-group col-md-6">
						<label for="title">{#wordsTitle#}</label>
						<input id='title' name='title' value='' type='text' size='30' class="form-control">
					</div>

					<div class="form-group col-md-6">
						<label for="alias">{#courseNewFormShortTitle_alias_#}</label>
						<input id='alias' name='alias' value='' type='text' class="form-control" {IF $IS_ASSIGNMENT_UPDATE eq 1} disabled="true" {/if}>
						<p class="help-block">{#courseAssignmentNewFormShortTitle_alias_Desc#}</p>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6">
						<label for="start_time">{#courseNewFormStartDate#}</label>
						<input id='start_time' name='start_time' value='' class="form-control" type='text' size ='16'>
						<p class="help-block">{#courseAssignmentNewFormStartDateDesc#}</p>
					</div>

					<div class="form-group col-md-6">
						<label for="finish_time">{#courseNewFormEndDate#}</label>
						<input id='finish_time' name='finish_time' value='' class="form-control" type='text' size='16'>
						<p class="help-block">{#courseAssignmentNewFormEndDateDesc#}</p>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-6">
						<label for="assignment_type">{#courseAssignmentNewFormType#}</label>
						<select name='assignment_type' id='assignment_type' class="form-control">
							<option value='homework'>{#wordsHomework#}</option>
							<option value='test'>{#wordsTest#}</option>
						</select>
						<p class="help-block">{#courseAssignmentNewFormTypeDesc#}</p>
					</div>

					<div class="form-group col-md-6">
						<label for="description">{#courseNewFormDescription#}</label>
						<textarea id='description' name='description' cols="30" rows="10" class="form-control"></textarea>
					</div>
				</div>

				<div class="form-group">
				{if $IS_ASSIGNMENT_UPDATE eq 1}
					<button type='submit' class="btn btn-primary">{#courseAssignmentNewFormUpdate#}</button>
				{else}
					<button type='submit' class="btn btn-primary">{#courseAssignmentNewFormSchedule#}</button>
				{/if}
				</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="/js/course.assignment.new.form.js?ver=7224f1"></script>
