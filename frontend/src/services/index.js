import axios from 'axios'

export default {
    getProgrammes(minimum){
        return minimum !== undefined ? axios.get(`/programmes/${minimum}`) : axios.get('/programmes/')
    },
    createProgramme(name, margin){
        return axios.post('/programmes/', {name, margin})
    }
}