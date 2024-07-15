// state.js
const state = {
    user: {
      token: sessionStorage.getItem('TOKEN'),
      data: {}
    },
    products: {
      loading: false,
        data: [],
        link:[],
        from: null,
        to: null,
        page: 1,
        limit: null,
      total:null
    }
  };
  
  export default state;
  