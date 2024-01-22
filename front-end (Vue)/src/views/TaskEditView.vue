
<template>
  <div>
    <AuthComponent/>
    <TaskEditComponent />
  </div>
</template>

<script>
import AuthComponent from '../components/AuthComponent';
import TaskEditComponent from '../components/TaskEditComponent';

export default {
  components: {
    AuthComponent,
    TaskEditComponent
  },
};
</script>