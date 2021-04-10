<template>
  <v-app id="inspire">
    <v-app id="inspire">
      <v-navigation-drawer
        v-model="drawer"
        app
      >
        <v-list dense>
          <v-list-item link to="/dashboard/projects">
            <v-list-item-action>
              <v-icon>mdi-home</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Projects</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item link to="/dashboard/calender">
            <v-list-item-action>
              <i class="fa fa-calendar" aria-hidden="true"></i>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Calender</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item link @click="logout">
            <v-list-item-action>
              <v-icon>mdi-door</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Logout</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
  
      <v-app-bar
        app
        color="indigo"
        dark
      >
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>Project Management Application</v-toolbar-title>
      </v-app-bar>
  
      <v-main>
        <v-container
          class="fill-height"
          fluid
        >
          <v-row
            justify="center"
          >
            <router-view></router-view>
          </v-row>
        </v-container>
      </v-main>
      <v-footer
        color="indigo"
        app
      >
        <span class="white--text">&copy; {{ new Date().getFullYear() }}</span>
      </v-footer>
    </v-app>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    drawer: null,
  }),
methods: {
   logout:function()
       {
        localStorage.removeItem('token');
        //routing to login page
        this.$router.push('/login').then(res => {
            this.text = 'logged out!';
            this.snackbar = true;
        }).catch(
        err => console.warn(err)
        );       
       },
   },
}
</script>
