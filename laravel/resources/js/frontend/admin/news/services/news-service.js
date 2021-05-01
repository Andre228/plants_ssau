import {RequestService} from "../../../request-services/request-service";

export class NewsService {

    constructor() {
        this.requestService = new RequestService();
    }


    store(_body) {
        const url = `/admin/museum/news/`;
        return this.requestService.store(url, _body);
    }

    update(newsId, _body) {
        const url = `/admin/museum/news/${newsId}`;
        return this.requestService.update(url, _body);
    }



}