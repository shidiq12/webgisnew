<template>
    <div class="container">
        <div class="row">
          <div class="col-md-12 mt-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Wiatas Table</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal"><i class="fas fa-plus"></i> Add Wisata </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Deskripsi</th>
                      <th>Longitude</th>
                      <th>Latitude</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(wisata, index) in wisatas.data" :key="wisata.id"> 
                      <td>{{++index}}</td>
                      
                      <td>{{wisata.placeName}}</td>
                      <td>{{wisata.vicinity}}</td>
                      <td>{{wisata.longitude}}</td>
                      <td>{{wisata.latitude}}</td>
                      <td>
                        <a href="#" data-id="wisata.id" @click="editModal(wisata)">
                            <i class="fa fa-edit blue"></i>
                        </a>/
                        <a href="#" @click="deleteWisata(wisata.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                  <pagination :data="wisatas" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode" id="addNewLabel">Add Wisata</h5>
                         <h5 class="modal-title" v-show="editMode" id="addNewLabel">Update Wisata</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form @submit.prevent="editMode ? updateWisata() : createWisata()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="placeName">Nama</label>
                                    <input v-model="form.placeName" type="text" name="placeName" class="form-control" :class="{ 'is-invalid': form.errors.has('placeName') }">
                                    <has-error :form="form" field="placeName"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="vicinity">Deskripsi</label>
                                    <input v-model="form.vicinity" type="text" name="vicinity" class="form-control" :class="{ 'is-invalid': form.errors.has('vicinity') }">
                                    <has-error :form="form" field="vicinity"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="longitude">longitude</label>
                                    <input v-model="form.longitude" type="text" name="longitude" class="form-control" :class="{ 'is-invalid': form.errors.has('longitude') }">
                                    <has-error :form="form" field="longitude"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="latitude">latitude</label>
                                    <input v-model="form.latitude" type="text" name="latitude" class="form-control" :class="{ 'is-invalid': form.errors.has('latitude') }">
                                    <has-error :form="form" field="latitude"></has-error>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
                            <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                editMode: false,
                wisatas: {},
                form: new Form({
                    placeName: '',
                    vicinity: '',
                    longitude: '',
                    latitude: '',
                })    
            }
        },

        methods: {
            getResults(page = 1) {
			axios.get('api/wisata?page=' + page)
				.then(response => {
					this.wisatas = response.data;
                });
            },
            updateWisata(){
                this.$Progress.start();
                 this.form.put('api/wisata/'+this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                    Swal.fire(
                    'Updated!',
                    'Your file has been Updated!.',
                    'success'
                    )
                this.$Progress.finish();
                Fire.$emit('AfterCreate');
                })
               .catch(()=>{
                this.$Progress.fail();
               })
            },
            editModal(wisata){
                this.editMode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(wisata)
            },

            newModal(){
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },

            deleteWisata(id){
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.value) {
                    axios.delete('api/wisata/'+id)
                    .then(() => {
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                        Fire.$emit('AfterCreate');
                    }).catch(() => {
                        Swal.fire(
                        "Failed",
                        "There was something wronge",
                        "Warning"
                        )
                    });
                  }
                })  
            },

            loadWisatas(){
                axios.get("api/wisata")
                .then(({ data }) => (
                    this.wisatas = data));
            },

            createWisata(){
                this.$Progress.start();
                this.form.post('api/wisata')
                .then(() => {
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                    icon: 'success',
                    title: 'Created Data in successfully'
                    })
                this.$Progress.finish();
                }).catch(() => {
                    this.$Progress.fail();
                })
                }
            },
            
            created() {
                Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('api/findwisata?q=' + query)
                .then((data) => {
                    this.wisatas = data.data
                })
                .catch(() => {
                })
            })
                this.loadWisatas();
                Fire.$on('AfterCreate',() => {
                    this.loadWisatas();
                });
            }, 
    }
</script>