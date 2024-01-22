
<template>
  <div>
    <AuthComponent/>
    <TaskNewComponent />
  </div>
</template>

<script>
import AuthComponent from '../components/AuthComponent';
import TaskNewComponent from '../components/TaskNewComponent';

export default {
  components: {
    AuthComponent,
    TaskNewComponent
  },
};
</script>