<template>
<v-app>
 <v-container>
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
 </v-container>
</v-app>
</template>

<script>
import axios from 'axios'
import draggable from 'vuedraggable'

export default {
    components: {
      draggable,
    },
    data: function () {
        return {
            todo: [],
            doing: [],
            done: [],
            old:'',
            new:'',
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
