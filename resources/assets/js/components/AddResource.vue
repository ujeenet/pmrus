<script>
    export default{
        data: function(){
            return {
                form:{
                    name:"",
                    lastname:"",
                    middlename:"",
                    phone:"",
                    email:"",
                    birthdate:"",
                    title:"",
                },
                edit: true,
                errors:{}
            }
        },
        methods:{
            sendForm: function(){
                axios.post('/resource/create',{"form":this.form})
                    .then(function(response){
                        if(response.data.errors){
                            this.errors = response.data.errors;
                        }else{
//                        EMITTER
                            Event.$emit('addresourceresponse', response.data);
                        //    console.log(response.data);
//                    COLLAPSE BOX
                            $('.box-success').addClass('collapsed-box');
                            $('.fa-minus').addClass('fa-plus').removeClass('fa-minus');
//                    CLEAR FORM
                            this.form.name = "";
                            this.form.middlename = "";
                            this.form.lastname = "";
                            this.form.email = "";
                            this.form.phone = "";
                            this.form.birthdate = "";
                            this.form.title = "";
//                    ALERT USER ON SUCCESS
                            swal(
                                'SAVED',
                                'Task has been successfully saved!',
                                'success'
                            );
                        }
                }.bind(this))
                    .catch(function(response){
                }.bind(this));
            },
            editResource: function(id){

            }

        }
    }
</script>