<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

      <div class="btn-group pull-right" role="group" style="display:flex;">
        <button class="btn btn-warning btn-sm" role="button" @click="edit">
          <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
        <button class="btn btn-primary btn-sm" role="button" @click="back">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </button>
      </div>
    </div>

    <div class="card-body">
      <dl class="row">
          <dt class="col-4">Nomor UN</dt>
          <dd class="col-8">{{ model.nomor_un }}</dd>

          <dt class="col-4">Nama Siswa</dt>
          <dd class="col-8">{{ model.siswa.nama_siswa }}</dd>

          <dt class="col-4">B. Indonesia</dt>
          <dd class="col-8">{{ model.bahasa_indonesia }}</dd>

          <dt class="col-4">B. Inggris</dt>
          <dd class="col-8">{{ model.bahasa_inggris }}</dd>

          <dt class="col-4">Matematika</dt>
          <dd class="col-8">{{ model.matematika }}</dd>

          <dt class="col-4">IPA</dt>
          <dd class="col-8">{{ model.ipa }}</dd>
      </dl>
    </div>

    <div class="card-footer text-muted">
      <div class="row">
        <div class="col-md">
          <b>Username :</b> {{ model.user.name }}
        </div>
        <div class="col-md">
          <div class="col-md text-right">Dibuat : {{ model.created_at }}</div>
          <div class="col-md text-right">Diperbarui : {{ model.updated_at }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2';

export default {
  data() {
    return {
      state: {},
      title: 'View Akademik',
      model: {
        nomor_un          : '',
        bahasa_indonesia  : '',
        bahasa_inggris    : '',
        matematika        : '',
        ipa               : '',
        user_id           : '',
        created_at        : '',
        updated_at        : '',

        siswa             : [],
        user              : [],
      },
    }
  },
  mounted() {
    let app = this;

    axios.get('api/akademik/'+this.$route.params.id)
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.model.nomor_un         = response.data.akademik.nomor_un;
          this.model.bahasa_indonesia = response.data.akademik.bahasa_indonesia;
          this.model.bahasa_inggris   = response.data.akademik.bahasa_inggris;
          this.model.matematika       = response.data.akademik.matematika;
          this.model.ipa              = response.data.akademik.ipa;
          this.model.user_id          = response.data.akademik.user_id;
          this.model.created_at       = response.data.akademik.created_at;
          this.model.updated_at       = response.data.akademik.updated_at;

          this.model.siswa            = response.data.akademik.siswa;
          this.model.user             = response.data.akademik.user;

          if (this.model.siswa === null) {
            this.model.siswa = {
              'id'          :this.model.nomor_un,
              'nama_siswa'  :''
            };
          }

          if (this.model.user === null) {
            this.model.user = {
              'id'    : this.model.user_id,
              'name'  : ''
            };
          }
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );

          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );

        app.back();
      });
  },
  methods: {
    edit() {
      window.location = '#/admin/akademik/'+this.$route.params.id+'/edit';
    },
    back() {
      window.location = '#/admin/akademik';
    }
  }
}
</script>