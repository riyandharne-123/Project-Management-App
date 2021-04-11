
<template>
  <div>
    <v-alert
      v-model="display"
      dismissible
      close-icon="mdi-delete"
      color="indigo"
      border="left"
      elevation="2"
      colored-border
    >
     {{ text }}
    </v-alert>
  </div>
</template>

<script>
  export default {
    props: ['display','text'],
  }
</script>