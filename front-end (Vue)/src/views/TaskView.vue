

<template>
  <div>
    <AuthComponent/>
    <TaskComponent />
  </div>
</template>

<script>
import AuthComponent from '../components/AuthComponent';
import TaskComponent from '../components/TaskComponent';

export default {
  components: {
    AuthComponent,
    TaskComponent
  },
};
</script>