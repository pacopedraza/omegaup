<template>
  <div class="omegaup-course-addstudent panel">
    <div class="panel-body">
      <form class="form" v-on:submit.prevent="onAddStudent">
        <div class="form-group">
          <label for="member-username">{{ T.wordsStudent }}</label>
          <span data-toggle="tooltip" data-placement="top" v-bind:title="T.courseEditAddStudentsTooltip"  class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
          <input v-model="studentUsername" type="text" size="20" class="form-control" autocomplete="off" />
        </div>
        <div class="form-group pull-right">
          <button class="btn btn-primary" type="submit">{{ T.wordsAddStudent }}</button>
          <button v-on:click.prevent="onCancel" class="btn btn-secondary" type="reset">{{ T.wordsCancel }}</button>
        </div>
      </form>
      <div>
          <table class="table table-striped table-over">
            <thead>
              <th>{{ T.wordsUser }}</th>
              <th class="align-right">{{ T.contestEditRegisteredAdminDelete }}</th>
            </thead>
            <tbody>
              <tr v-for="student in students">
                <td><a v-bind:href="'/profile/' + student.username + '/'">{{ student.name || student.username }}</a></td>
                <td><button type="button" class="close" v-on:click="onRemove(student)">&times;</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import UI from '../../ui.js';

export default {
  props: {
    T: Object,
    students: Array,
  },
  data: function() {
    return {
      studentUsername: '',
    };
  },
  mounted: function() {
    UI.userTypeahead($('input', $(this.$el)));
  },
  methods: {
    onAddStudent: function() {
      this.$emit('add-student', this.studentUsername);
    },
    onCancel: function() {
      this.$emit('cancel');
    },
    onRemove: function(student) {
      this.$emit('remove', student);
    },
    reset: function() {
      this.studentUsername = '';
    },
  },
};
</script>

<style>
.omegaup-course-addstudent th.align-right {
  text-align: right;
}
</style>
