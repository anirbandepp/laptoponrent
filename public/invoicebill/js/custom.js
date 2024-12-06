
  import { MDBCol, MDBRow, MDBInput, MDBCheckbox, MDBBtn } from "mdb-vue-ui-kit";
  import { ref } from "vue";
  export default {
    components: {
      MDBCol,
      MDBRow,
      MDBInput,
      MDBCheckbox,
      MDBBtn
    },
    setup() {
      const checkForm = e => {
        e.target.classList.add("was-validated");
      };
      const input1 = ref("Mark");
      const input2 = ref("Otto");
      const input3 = ref("");
      const input4 = ref("");
      const input5 = ref("");
      const checkbox1 = ref(false);
      return {
        input1,
        input2,
        input3,
        input4,
        input5,
        checkbox1,
        checkForm
      };
    }
  };
