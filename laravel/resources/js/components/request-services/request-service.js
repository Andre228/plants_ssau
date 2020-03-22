import axios from "axios";

export class RequestService {


    constructor() {
    }


    update(url, _body) {
        return axios.patch(url, _body);
    }

    destroy(url) {
       return axios.delete(url);
    }

    store(url, _body) {
        return axios.post(url, _body)
    }

}