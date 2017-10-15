<script>
    export default {
        props: ['pid'],
         data: function () {
             return {
                 checkpoint: {
                     title: "",
                     status: "",
                     estimated_duration: "",
                     resource_id: "",
                     priority:"",
                 },
                 resources:[],

                 forms: []
//                     title:"none"
                 ,
                 formsDone: []
//                     title:"none"
                 ,
                 formsOnhold: []
//                     title:"none"
                 ,
                 formsDiscard:[]
                 ,
//                     title:"none"
                 formsAdditional:[]
//                     title:"none"

             }
         },
        methods:{
             getCheckpoints: function (){

                 this.clearForms();

                axios.get("/checkpoint/listall/"+this.pid).then(function(response){

                    if (response.data.in_process) {
                        this.forms = response.data.in_process;
                    }
                    if (response.data.done){
                        this.formsDone = response.data.done;
                    }
                    if (response.data.on_hold){
                        this.formsOnhold = response.data.on_hold;
                    }
                    if (response.data.discard){
                        this.formsDiscard = response.data.discard;
                    }
                    if (response.data.additional){
                        this.formsAdditional=response.data.additional;

                        this.forms = this.forms.concat(this.formsAdditional);
                    }
                    this.forms.sort(function (a,b) {
                            return a.priority-b.priority;
                        });

                 }.bind(this)).catch(function(errors){
                    console.log(errors);
                });
                },
            getResourceList: function () {
                axios.get('/resource/listall').then(function(response){
                    this.resources = response.data;
                }.bind(this)).catch(function (errors) {
                    console.log(errors);
                });
            },

            clearForms: function (){
                 this.forms=[];
            },

            dragUp: function (id ,form){
                 if (id > 0){
                this.forms.splice(id, 1);
                this.forms.splice(id-1 ,0, form);
                this.forms.forEach(function(item, i, arr) {
                    item.priority = i + 1;
                })
                 }
             },
            dragDown: function (id ,form){
                this.forms.splice(id, 1);
                this.forms.splice(id +1 ,0, form);
                this.forms.forEach(function(item, i, arr){
                    item.priority=i+1;
                })
             },
            checkpointDelete: function (id ,form, checkpointid){
                axios.delete('/checkpoint/delete/'+form.id).then(function(response)
                {
                    this.forms.splice(id, 1);
                    this.forms.forEach(function(item, i, arr)
                    {
                        item.priority=i+1;
                    });
                    this.sendForms();
                }.bind(this));

             },
            sendForms: function () {
                axios.post('/checkpoint/update', {forms:this.forms}).then(function()
                {
                    this.forms.forEach(function(item, i, arr){
                        item.priority=i+1;
                    });
                    this.estimateDates();
                }.bind(this)).catch(function(errors){
                console.log(errors);
            });

            },
            addCheckpoint: function () {
                axios.post("/checkpoint/create", {"pid": this.pid, "checkpoint": this.checkpoint}).then(function(response)
                    {
                        if(response.data.status==='in_process'){
                            this.forms.push({
                                'id': response.data.id,
                                'title': response.data.title,
                                'estimated_duration': response.data.estimated_duration,
                                'status': response.data.status,
                                'project_id': response.data.project_id,
                                'start_date': response.data.start_date,
                                'finish_date': response.data.finish_date,
                                'created_at': response.data.created_at,
                                'updated_at': response.data.updated_at,
                                'resource_id': response.data.resource_id,
                            });
                        }
                        if(response.data.status==='additional'){
                            this.forms.push({
                                'id': response.data.id,
                                'title': response.data.title,
                                'estimated_duration': response.data.estimated_duration,
                                'status': response.data.status,
                                'project_id': response.data.project_id,
                                'start_date': response.data.start_date,
                                'finish_date': response.data.finish_date,
                                'created_at': response.data.created_at,
                                'updated_at': response.data.updated_at,
                                'resource_id': response.data.resource_id,
                            });
                        }
                        if(response.data.status==='on_hold'){
                            this.formsOnhold.push({
                                'id': response.data.id,
                                'title': response.data.title,
                                'estimated_duration': response.data.estimated_duration,
                                'status': response.data.status,
                                'project_id': response.data.project_id,
                                'start_date': response.data.start_date,
                                'finish_date': response.data.finish_date,
                                'created_at': response.data.created_at,
                                'updated_at': response.data.updated_at,
                                'resource_id': response.data.resource_id,
                            });
                        }
                        if(response.data.status==='done'){
                            this.formsDone.push({
                                'id': response.data.id,
                                'title': response.data.title,
                                'estimated_duration': response.data.estimated_duration,
                                'status': response.data.status,
                                'project_id': response.data.project_id,
                                'start_date': response.data.start_date,
                                'finish_date': response.data.finish_date,
                                'created_at': response.data.created_at,
                                'updated_at': response.data.updated_at,
                                'resource_id': response.data.resource_id,
                            });
                        }

                        this.forms.forEach(function(item, i, arr){
                            item.priority=i+1;
                        });
                        this.estimateDates();
                    }.bind(this));
            },
            estimateDates: function () {
                axios.get('/checkpoint/estimate/' + this.pid).then(function (response) {

                    this.getCheckpoints();

                }.bind(this)).catch(function (errors) {
                    console.log(errors);
                });
            },
            convertTime:function (timestamp){

                var d = new Date(timestamp*1000);

                var curr_date = d.getDate();

                var curr_month = d.getMonth() + 1;

                var curr_year = d.getFullYear();

                return (curr_date + "-" + curr_month + "-" + curr_year);

            }
        },
        mounted: function (){

            this.getCheckpoints();
            this.getResourceList();

        }
    }
</script>