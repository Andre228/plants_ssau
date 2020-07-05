import {RequestService} from "../../../request-services/request-service";


export class UserService {

    constructor() {
        this.requestService = new RequestService();
    }


   get(url) {
       // const usersPage = 1;
       //
       // if (!url) {
       //     url = `/admin/museum/getusers/per-page`; //categories/per-page?page=2
       // }
       // console.log(url);
       // return this.requestService.get(url);
   }

}