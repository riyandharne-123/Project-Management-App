<template>
<v-app>

<Alert :display="alert" :text="alert_text" style="margin:10px;" />

<v-row justify="center">
<div v-for="project in projects" :key="project.id">
<v-col>
<v-card
    class="mx-auto"
    max-width="400"
  >
    <v-img
      class="white--text align-end"
      height="200px"
      :src="project.image"
    >
      <v-card-title>{{ project.name }}</v-card-title>
    </v-img>

    <v-card-text class="text--primary">
      <div>{{ project.description }}</div>
    </v-card-text>

    <v-card-actions>

    <router-link :to='"/dashboard/tasks/"+project.project_url'>
      <v-btn
        color="indigo"
        text
      >
        View Tasks
      </v-btn>
    </router-link>
      
      <v-spacer></v-spacer>

      <v-btn
        color="indigo"
        style="color:white;"
        @click="getProject(project.id)"
      >
        Delete Project
      </v-btn>

    </v-card-actions>
</v-card>
</v-col>
</div>

</v-row>

  <v-btn
    bottom
    color="red"
    dark
    fab
    fixed
    right
    @click="dialog = !dialog"
  >
    <v-icon>mdi-plus</v-icon>
  </v-btn>

<!--Dialog-->

<v-dialog
  v-model="dialog"
  width="800px"
>
  <v-card>
    <v-card-title class="indigo" style="color:white;">
      Create Project
    </v-card-title>
    <v-container>
      <v-row class="mx-2">
        <v-col
          class="align-center justify-space-between"
          cols="12"
        >
          <v-row
            align="center"
            class="mr-0"
          >
            <v-avatar
              size="40px"
              class="mx-3"
            >
              <img
                src="//ssl.gstatic.com/s2/oz/images/sge/grey_silhouette.png"
                alt=""
              >
            </v-avatar>
            <v-text-field
              placeholder="Name"
              v-model="name"
              required
            ></v-text-field>
          </v-row>
        </v-col>
        <v-col cols="12">
        <v-textarea
          class="mx-2"
          placeholder="Description"
          rows="1"
          prepend-icon="mdi-comment"
          v-model="description"
          required
        ></v-textarea>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-select
            :items="items"
            label="Images"
            v-model="image"
          >
          <template v-slot:selection="{ item }">
            <v-container fluid>
              <v-img :src="item" height="100"> </v-img>
            </v-container>
          </template>
          <template v-slot:item="{ item }">
            <v-container fluid>
              <v-img :src="item" height="100"> </v-img>
            </v-container>
          </template>
          </v-select>
        </v-col>
      </v-row>
    </v-container>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn
        text
        color="primary"
        @click="dialog = false"
      >Cancel</v-btn>
      <v-btn
        text
        @click="addProject()"
      >Save</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>

<!--Delete-Dialog-->

<v-dialog v-model="delete_dialog" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">Do you wantto delete Project {{project.name}} ?</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="indigo darken-1" text @click="delete_dialog = false">Disagree</v-btn>
          <v-btn color="indigo darken-1" text @click="deleteProject(project.id)">Agree</v-btn>
        </v-card-actions>
      </v-card>
  </v-dialog>

</v-app>
</template>

<script>
import axios from 'axios';
import Alert from '../alerts/Alert'

export default {
    components: {
      Alert,
    },
    data: function () {
        return {
          projects:[],
          dialog: false,
          name: "",
          description: "",
          items:["https://cdn.vuetifyjs.com/images/parallax/material.jpg",
          "https://cdn.vuetifyjs.com/images/parallax/material2.jpg",
          "https://picsum.photos/500/300?image=25",
          "https://picsum.photos/500/300?image=30",
          "https://picsum.photos/500/300?image=35"
          ],
          image: "",
          alert: false,
          alert_text: "",
          project: [],
          delete_dialog: false,
        }
    },
    created:function(){
      axios.get('/api/projects')
       .then(res => {
         this.projects = res.data.projects        
       })
    },
    methods: {
      addProject()
      {
       axios.post('/api/projects',{
         'name': this.name,
         'description': this.description,
         'image': this.image,
       })
       .then(res => {
         this.projects = res.data.projects        
         this.dialog = false
         this.name = "";
         this.description = "";
         this.image = "";
         this.alert = true;
         this.alert_text = "Project Created!";
       })
       .catch(err =>{
         this.dialog = false;
         this.alert = true;
         this.alert_text = "Error!";
         this.name = "";
         this.description = "";
         this.image = "";
       })
      },

      getProject(id)
      {
        axios.get(`/api/projects/${id}`)
        .then(res => {         
          this.project = res.data.project
          this.delete_dialog = true

        }).catch(err =>{
          console.warn(err)
        })
      },

      deleteProject(id)
      {
        axios.delete(`/api/projects/${id}`)
        .then(res => {
          this.projects = res.data.projects
          this.delete_dialog = false
          this.alert = true;
         this.alert_text = "Project Deleted!";        
        }).catch(err =>{
          console.warn(err)
        })
      }
    },
}
</script>
