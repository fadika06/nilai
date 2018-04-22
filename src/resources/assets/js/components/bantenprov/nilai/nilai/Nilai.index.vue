<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Nilai

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="createRow">
          	<i class="fa fa-plus" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <vuetable-filter-bar></vuetable-filter-bar>
      </div>

      <div style="margin:20px 0;">
        <div v-if="loading" class="d-flex justify-content-start align-items-center">
          <i class="fa fa-refresh fa-spin fa-fw"></i>
          <span>Loading...</span>
        </div>
      </div>

      <div class="table-responsive">
        <vuetable ref="vuetable"
          api-url="/api/nilai"
          :fields="fields"
          :sort-order="sortOrder"
          :css="css.table"
          pagination-path=""
          :per-page="5"
          :append-params="moreParams"
          @vuetable:pagination-data="onPaginationData"
          @vuetable:loading="onLoading"
          @vuetable:loaded="onLoaded">
          <template slot="actions" slot-scope="props">
            <div class="btn-group pull-right" role="group" style="display:flex;">
              <button class="btn btn-info btn-sm" role="button" @click="viewRow(props.rowData)">
                <span class="fa fa-eye"></span>
              </button>
              <button class="btn btn-warning btn-sm" role="button" @click="editRow(props.rowData)">
                <span class="fa fa-pencil"></span>
              </button>
              <button class="btn btn-danger btn-sm" role="button" @click="deleteRow(props.rowData)">
                <span class="fa fa-trash"></span>
              </button>
            </div>
          </template>
        </vuetable>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <vuetable-pagination-info ref="paginationInfo"
        ></vuetable-pagination-info>
        <vuetable-pagination ref="pagination"
          :css="css.pagination"
          @vuetable-pagination:change-page="onChangePage">
        </vuetable-pagination>
      </div>
    </div>
  </div>
</template>

<style>
.vuetable-th-sequence{
  width: 1px;
}
.vuetable-th-slot-actions {
  width: 1px;
  white-space: normal;
}
</style>

<script>
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo';

export default {
  components: {
    VuetablePaginationInfo
  },
  data() {
    return {
      loading: true,
      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'center aligned',
          dataClass: 'right aligned'
        },
        {
          name: 'siswa.nama_siswa',
          title: 'Nama Siswa',
          sortField: 'nomor_un',
          titleClass: 'center aligned'
        },
        {
          name: 'akademik',
          title: 'Akademik',
          sortField: 'akademik',
          titleClass: 'center aligned'
        },
        {
          name: 'prestasi',
          title: 'Prestasi',
          sortField: 'prestasi',
          titleClass: 'center aligned'
        },
        {
          name: 'zona',
          title: 'Zona',
          sortField: 'zona',
          titleClass: 'center aligned'
        },
        {
          name: 'sktm',
          title: 'Sktm',
          sortField: 'sktm',
          titleClass: 'center aligned'
        },
        {
          name: 'user.name',
          title: 'Username',
          sortField: 'user_id',
          titleClass: 'center aligned'
        },
        {
          name: '__slot:actions',
          title: 'Actions',
          titleClass: 'center aligned',
          dataClass: 'center aligned'
        },
      ],
      sortOrder: [{
        field: 'id',
        direction: 'asc'
      }],
      moreParams: {},
      css: {
        table: {
          tableClass: 'table table-hover',
          ascendingIcon: 'fa fa-chevron-up',
          descendingIcon: 'fa fa-chevron-down'
        },
        pagination: {
          wrapperClass: 'vuetable-pagination btn-group',
          activeClass: 'active',
          disabledClass: 'disabled',
          pageClass: 'btn btn-light',
          linkClass: 'btn btn-light',
          icons: {
            first: 'fa fa-angle-double-left',
            prev: 'fa fa-angle-left',
            next: 'fa fa-angle-right',
            last: 'fa fa-angle-double-right'
          }
        }
      }
    }
  },
  methods: {
    createRow() {
      window.location = '#/admin/nilai/create';
    },
    viewRow(rowData) {
      window.location = '#/admin/nilai/' + rowData.id;
    },
    editRow(rowData) {
      window.location = '#/admin/nilai/' + rowData.id + '/edit';
    },
    deleteRow(rowData) {
      let app = this;

      if (confirm('Do you really want to delete it?')) {
        axios.delete('/api/nilai/' + rowData.id)
          .then(function(response) {
            if (response.data.status == true) {
              app.$refs.vuetable.reload()
            } else {
              alert('Failed');
            }
          })
          .catch(function(response) {
            alert('Break');
          });
      }
    },
    onPaginationData(paginationData) {
      this.$refs.pagination.setPaginationData(paginationData);
      this.$refs.paginationInfo.setPaginationData(paginationData);
    },
    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
    onLoading: function() {
      this.loading = true;
    },
    onLoaded: function() {
      this.loading = false;
    }
  },
  events: {
    'filter-set' (filterText) {
      this.moreParams = {
        filter: filterText
      }

      Vue.nextTick(() => this.$refs.vuetable.refresh())
    },
    'filter-reset'() {
      this.moreParams = {
        //
      }

      Vue.nextTick(() => this.$refs.vuetable.refresh())
    }
  }
}
</script>