<template>
  <v-app id="inspire">
      <v-snackbar
      v-model="snackbar"
    >
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="indigo"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  <v-progress-linear
  :active="loading"
  :indeterminate="loading"
  absolute
  top
  color="indigo accent-4"
  >
  </v-progress-linear>
      <v-main>
        <v-container
          class="fill-height"
          fluid
        
        >
          <v-row
            align="center"
            justify="center"
          >
            <v-col
              cols="12"
              sm="8"
              md="4"
            >
              <v-card class="elevation-12" >
                <v-toolbar
                  color="indigo"
                  style="color:white"
                  flat
                >
                  <v-toolbar-title style="color:white;">Register</v-toolbar-title>
                  <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                  <v-form
                  ref='form'
                  v-model='valid'
                  :lazy-validation ='true'
                  >
                    
                    <v-text-field
                      label="name"
                      name="name"
                      prepend-icon="mdi-account"
                      type="text"
                      v-model="name"
                      color="indigo"
                      required
                    ></v-text-field>

                    <v-text-field
                      label="email"
                      name="email"
                      prepend-icon="mdi-material-design"
                      type="email"
                      v-model="email"
                      color="indigo"
                      :rules="emailRules"
                      required
                    ></v-text-field>
  
                    <v-text-field
                      id="password"
                      label="Password"
                      name="password"
                      prepend-icon="mdi-lock"
                      type="password"
                      v-model="password"
                       color="indigo"
                        :rules="passwordRules"
                       required
                    ></v-text-field>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn 
                  color="indigo" 
                  :disabled = "!valid"
                   @click='login'
                   style="color:white"
                   >Register</v-btn>
                  <v-btn 
                  color="indigo"
                  style="color:white"
                  link to="/login" 
                   >or Login</v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-container>
      </v-main>
    </v-app>
</template>

<script>
    export default {
        data(){
            return{
       emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      passwordRules:[
          v => !!v || 'Password is required',
      ],
                valid:true,
                name:'',
                email:'',
                password:'',
                loading:false,
                snackbar:false,
                text:null,
            }
        },
        methods:{
            //login function api
            login:function()
            {
              axios.interceptors.request.use((config)=> {
               this.loading = true;
               return config;
              },(error)=> {
                  this.loading = false;
                return Promise.reject(error);
              });

              axios.interceptors.response.use((response)=> {
                 this.loading = false;
               return response;
              },(error)=> {
                  this.loading = false;
                return Promise.reject(error);
              });
              axios.post('/api/register', {
                'name':this.name,
                'email':this.email,
                'password':this.password,
              }).then(res => {
                //console.dir(res)
              localStorage.setItem('token',res.data.token);
               localStorage.setItem('loggedIn',true);
              //routing to admin panel
              this.$router.push('/dashboard').then(
                res => console.log('logged in')
              ).catch(
                err => console.warn(err)
              );
              })
              .catch(err =>{
                //console.dir(err.response.data)
                 this.snackbar = true;
                 this.text = err;
                 });
            }
        }
    }
</script>
