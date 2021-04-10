<template>
<v-app>

<v-app-bar
    app
    color="indigo"
    dark
    >
    <v-toolbar-title>Project Management Application</v-toolbar-title>

    <v-spacer></v-spacer>

    <v-btn style="margin:5px" link to="/login">
        Login
    </v-btn>

    <v-btn style="margin:5px" link to="/register">
        Register
    </v-btn>

</v-app-bar>

 <router-view></router-view>
</v-app>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
