import CategoriesComponent from './frontend/admin/categories/CategoriesComponent';

import PostsComponent from "./frontend/admin/posts/PostsComponent";
import PostDetailsComponent from "./frontend/admin/posts/PostDetailsComponent";
import PostCardComponent from "./frontend/admin/posts/PostCardComponent";
import CreatePostComponent from "./frontend/admin/posts/create-post/CreatePostComponent";

import UserComponent from './frontend/admin/users/edit/UserComponent'
import NewsComponent from './frontend/admin/news/NewsComponent';
import CreateNewsComponent from './frontend/admin/news/CreateNewsComponent';
import NewsDetailsComponent from './frontend/admin/news/NewsDetailsComponent';
import {componentsModule} from "./frontend/components/components.module";





export const componentsProvider = {
    ...componentsModule,

    CategoriesComponent,

    PostsComponent,
    PostDetailsComponent,
    PostCardComponent,
    CreatePostComponent,

    UserComponent,

    NewsComponent,
    NewsDetailsComponent,
    CreateNewsComponent,
};
