<template>
  <div class="container">
      <h3 align="center" class="mt-5">Employee Management</h3>
      <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
          <div class="form-area">
            <form @submit.prevent="save" id="check-register-form">
                  <div class="row">
                      <div class="col-md-6">
                        <label>Employee Name</label>
                        <v-text-field
                        v-model="employee.emp_name"
                        label="Employee Name"
                        required>
                        </v-text-field>
                      </div>
                      <div class="col-md-6">
                          <label>Employee DOB</label>
                          <v-text-field
                          v-model="employee.dob"
                          label="Employee DOB"
                          required>
                          </v-text-field>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <label>Phone</label>
                          <v-text-field
                          v-model="employee.phone"
                          label="Employee Phone"
                          required>
                          </v-text-field>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12 mt-3">
                        <v-btn type="submit" color="success">Save</v-btn>
                      </div>
                  </div>
              </form>
          </div>

          <v-table theme="dark">
            <thead>
              <tr>
                <th class="text-left">Employee ID</th>
                <th class="text-left">Employee Name</th>
                <th class="text-left">DOB</th>
                <th class="text-left">Phone</th>
                <th class="text-left">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="employee in result" :key="employee.id">
                <td>{{ employee.id }}</td>
                <td>{{ employee.emp_name }}</td> <!-- Corrected property -->
                <td>{{ employee.dob }}</td>
                <td>{{ employee.phone }}</td>
                <td>
                  <v-btn type="button" color="info" @click="edit(employee)">Edit</v-btn>
                  <v-btn type="button" color="danger" @click="remove(employee)">Delete</v-btn>
                </td>        
              </tr>
            </tbody>
          </v-table>
          </div>
      </div>
  </div>
</template>

<script>
import axios from 'redaxios';

export default {
  name: 'Employee',
  data() {
    return {
      result: [],
      employee: {
        id: '',
        emp_name: '', // Ensure it matches backend API
        dob: '',
        phone: ''
      }
    };
  },
  created() { 
    this.EmployeeLoad();
  },
  methods: {
    EmployeeLoad() {
      axios.get("http://127.0.0.1:8000/api/getallemployee")
        .then(({ data }) => {
          this.result = data.data; // Ensure correct data structure
        });
    },
    save() {
      if (this.employee.id === '') {
        this.saveData();
      } else {
        this.updateData();
      }       
    },
    saveData() {
        axios.post("http://127.0.0.1:8000/api/addemployee", {
        emp_name: this.employee.emp_name,  // Match Laravel API field
        dob: this.employee.dob,
        phone: this.employee.phone
      })
      .then(() => {
        this.resetForm();
        this.EmployeeLoad();
      })
      .catch(error => {
        console.error("Error saving data:", error);
      });
    },
    edit(employee) {
      this.employee = { ...employee }; // Create a copy to avoid direct mutations
    },
    updateData() {
      axios.put(`http://127.0.0.1:8000/api/updateemployee/${this.employee.id}`, this.employee)
        .then(() => {
          alert("Updated Successfully!");
          this.resetForm();
          this.EmployeeLoad();
        });
    },
    remove(employee) {
      axios.delete(`http://127.0.0.1:8000/api/deleteemployee/${employee.id}`)
        .then(() => {
          alert("Deleted Successfully!");
          this.EmployeeLoad();
        });
    },
    resetForm() {
      this.employee = { id: '', emp_name: '', dob: '', phone: '' };
    }
  }
};
</script>

<style scoped>
.form-area {
  padding: 20px;
  margin-top: 20px;
  background-color: #0b0b0b;
  color: #fffcfc;
}
</style>
