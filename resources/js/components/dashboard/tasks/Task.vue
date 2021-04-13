<template>
<v-app>
 <v-container>
     <Alert :display="alert" :text="alert_text" style="margin:10px;" />
    <v-row justify="center">
        <!--TODO-->
        <v-col cols="12" sm="4">
            <v-card
            >
                <v-card-text>
                <p class="display-1 text--primary">
                    Todo
                </p>
                <draggable :list="todo" group="todosapp" ghostClass="on-drag" @end="checkTodoMove" animation="300">
                    <div class="text--primary" v-for="task in todo" :key="task.id" :item="task">
                            <v-alert class="move"
                            :color="task.color"
                            border="left"
                            elevation="2"
                            colored-border
                            >
                            {{ task.name }}
                            <v-btn icon @click="getTask(task.id)">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn icon @click="deleteTask(task.id)">
                                <v-icon>mdi-trash-can</v-icon>
                            </v-btn>
                            </v-alert>
                    </div>
                </draggable>
                </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="orange"
                            text
                        >
                            Share
                        </v-btn>

                        <v-btn
                            color="orange"
                            text
                        >
                            Explore
                        </v-btn>
                    </v-card-actions>
            </v-card>
        </v-col>

        <!--Doing-->
        <v-col cols="12" sm="4">
            <v-card
            >
                <v-card-text>
                <p class="display-1 text--primary">
                    Doing
                </p>
                <draggable :list="doing" group="todosapp" ghostClass="on-drag" @end="checkDoingMove" animation="300">
                    <div class="text--primary" v-for="task in doing " :key="task.id" :item="task">
                            <v-alert class="move"
                            :color="task.color"
                            border="left"
                            elevation="2"
                            colored-border
                            >
                            {{ task.name }}
                            <v-btn icon @click="getTask(task.id)">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn icon @click="deleteTask(task.id)">
                                <v-icon>mdi-trash-can</v-icon>
                            </v-btn>
                            </v-alert>
                    </div>
                </draggable>
                </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="orange"
                            text
                        >
                            Share
                        </v-btn>

                        <v-btn
                            color="orange"
                            text
                        >
                            Explore
                        </v-btn>
                    </v-card-actions>
            </v-card>
        </v-col>

        <!--Done-->
        <v-col cols="12" sm="4">
            <v-card
            >
                <v-card-text>
                <p class="display-1 text--primary">
                    Done
                </p>
                <draggable :list="done" group="todosapp" ghostClass="on-drag" @end="checkDoneMove" animation="300">
                    <div class="text-primary" v-for="task in done" :key="task.id" :item="task">
                            <v-alert class="move"
                            :color="task.color"
                            border="left"
                            elevation="2"
                            colored-border
                            >
                            {{ task.name }}
                            <v-btn icon @click="getTask(task.id)">
                                <v-icon>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn icon @click="deleteTask(task.id)">
                                <v-icon>mdi-trash-can</v-icon>
                            </v-btn>
                            </v-alert>
                    </div>
                </draggable>
                </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="orange"
                            text
                        >
                            Share
                        </v-btn>

                        <v-btn
                            color="orange"
                            text
                        >
                            Explore
                        </v-btn>
                    </v-card-actions>
            </v-card>
        </v-col>
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
 </v-container>

<!--Dialog-->

<v-dialog
  v-model="dialog"
  width="800px"
>
  <v-card>
    <v-card-title class="indigo" style="color:white;">
      Create Task
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
        <v-col cols="12">
            <v-dialog
                ref="dialog1"
                v-model="start_date_modal"
                :return-value.sync="start_date"
                persistent
                width="290px"
            >
                <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="start_date"
                    label="Start Date"
                    prepend-icon="mdi-table-large"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                ></v-text-field>
                </template>
                <v-date-picker v-model="start_date" scrollable>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="start_date_modal = false">Cancel</v-btn>
                <v-btn text color="primary" @click="$refs.dialog1.save(start_date)">OK</v-btn>
                </v-date-picker>
            </v-dialog>
            </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
            <v-dialog
                ref="dialog"
                v-model="end_date_modal"
                :return-value.sync="end_date"
                persistent
                width="290px"
            >
                <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="end_date"
                    label="End Date"
                    prepend-icon="mdi-table-large"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                ></v-text-field>
                </template>
                <v-date-picker v-model="end_date" scrollable>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="end_date_modal = false">Cancel</v-btn>
                <v-btn text color="primary" @click="$refs.dialog.save(end_date)">OK</v-btn>
                </v-date-picker>
            </v-dialog>
            </v-col>
      </v-row>
        <v-row>
            <v-col
                cols="12"
                class="d-flex justify-center"
            >
                <v-color-picker v-model="color"></v-color-picker>
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
        v-if="saveOrUpdate == false"
        text
       @click="addTask()"
      >Save</v-btn>
    <v-btn
        v-if="saveOrUpdate == true"
        text
       @click="editTask()"
      >Update</v-btn>
    </v-card-actions>
  </v-card>
</v-dialog>

</v-app>
</template>

<script>
import axios from 'axios'
import draggable from 'vuedraggable'
import Alert from '../../alerts/Alert'

export default {
    components: {
      draggable,
      Alert,
    },
    data: function () {
        return {
            dialog: false,
            saveOrUpdate: false,
            start_date_modal: false,
            end_date_modal: false,
            name: '',
            description: '',
            start_date: '',
            end_date: '',
            color: '',
            todo: [],
            doing: [],
            done: [],
            old:'',
            new:'',
            alert: false,
            alert_text: "",
            updateId:"",
        }
    },
    watch:{
        todo(value){
            value.map(todo =>{
                axios.post(`/api/tasks/update/${todo.id}`,{
                    'project_url': this.$route.params.project_url,
                    'status': 0,
                })
            })
        },
        doing(value){
            value.map(todo =>{
                axios.post(`/api/tasks/update/${todo.id}`,{
                    'project_url': this.$route.params.project_url,
                    'status': 1,
                })
            })
        },
        done(value){
            value.map(todo =>{
                axios.post(`/api/tasks/update/${todo.id}`,{
                    'project_url': this.$route.params.project_url,
                    'status': 2,
                })
            })
        },
    },
    methods:{
        checkTodoMove: function(evt){
            this.old = evt.oldIndex;
            this.new = evt.newIndex;
            axios.post(`/api/update/position`,{
                'project_url': this.$route.params.project_url,
                'status': 0,
                "old": evt.oldIndex,
                "new": evt.newIndex,
            })
            .catch(err =>{
                console.warn(err)
            })
        },
        checkDoingMove: function(evt){
            this.old = evt.oldIndex;
            this.new = evt.newIndex;
            axios.post(`/api/update/position`,{
                'project_url': this.$route.params.project_url,
                'status': 1,
                "old": evt.oldIndex,
                "new": evt.newIndex,
            })
            .catch(err =>{
                console.warn(err)
            })
        },
        checkDoneMove: function(evt){
            this.old = evt.oldIndex;
            this.new = evt.newIndex;
            axios.post(`/api/update/position`,{
                'project_url': this.$route.params.project_url,
                'status': 2,
                "old": evt.oldIndex,
                "new": evt.newIndex,
            })
            .catch(err =>{
                console.warn(err)
            })
        },
        addTask()
        {
        axios.post('/api/tasks',{
            'project_url': this.$route.params.project_url,
            'name': this.name,
            'description': this.description,
            'start_date': this.start_date,
            "end_date": this.end_date,
            "color": this.color,
        })
        .then(res => {  
            this.name = "";
            this.description = "";
            this.start_date = "";
            this.end_date = "";
            this.color = "";
            this.alert = true;
            this.alert_text = "Task Created!";
        })
        .catch(err =>{
            this.dialog = false;
            this.alert = true;
            this.alert_text = "Error!";
            this.name = "";
            this.description = "";
            this.start_date = "";
            this.end_date = "";
            this.color = "";
        })

        axios.post('/api/project/tasks',{
            'project_url': this.$route.params.project_url,
        })
        .then(res => {
            this.todo = res.data.todo        
            this.doing = res.data.doing    
            this.done = res.data.done      
            this.dialog = false
        })
        },

        deleteTask(task_id)
        {
            axios.delete(`/api/tasks/${task_id}`)
            .then(res => {  
                this.alert = true;
                this.alert_text = "Task Deleted!";
            })
            axios.post('/api/project/tasks',{
                'project_url': this.$route.params.project_url,
            })
            .then(res => {
                this.todo = res.data.todo        
                this.doing = res.data.doing    
                this.done = res.data.done      
                this.name = "";
                this.description = "";
                this.start_date = "";
                this.end_date = "";
                this.color = "";
            })
        },

        getTask(task_id)
        {
            this.alert = false;
            this.saveOrUpdate = true;
            axios.get(`/api/tasks/${task_id}`)
            .then(res => {  
                this.dialog = true;
                this.name = res.data.task.name;
                this.description = res.data.task.description;
                this.start_date = res.data.task.start;
                this.end_date = res.data.task.end;
                this.color = res.data.task.color;
                this.updateId = res.data.task.id;
            })
        },

        editTask()
        {
            axios.put(`/api/tasks/${this.updateId}`,{
                'name': this.name,
                'description': this.description,
                'start_date': this.start_date,
                "end_date": this.end_date,
                "color": this.color,
            })
            .then(res => {  
                this.dialog = false;
                this.alert = true;
                this.alert_text = "Task Updated!";
            })
            axios.post('/api/project/tasks',{
                'project_url': this.$route.params.project_url,
            })
            .then(res => {
                this.todo = res.data.todo        
                this.doing = res.data.doing    
                this.done = res.data.done      
            })
        },

        },
        mounted:function(){
        axios.post('/api/project/tasks',{
            'project_url': this.$route.params.project_url,
        })
        .then(res => {
            this.todo = res.data.todo        
            this.doing = res.data.doing    
            this.done = res.data.done      
        })
        },
}
</script>

<style scoped>
.move
{
    cursor: move;
}
.on-drag{
    background-color: rgb(47, 132, 211);
    color: #fff;
    z-index: 10;
}
</style>
