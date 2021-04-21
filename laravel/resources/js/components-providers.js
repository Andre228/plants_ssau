import AdminCategoriesComponent from './frontend/components/AdminCategoriesComponent';
import ButtonComponent from './frontend/components/ButtonComponent';
import TableItemComponent from './frontend/components/TableItemComponent';
import ProfileComponent from './frontend/components/ProfileComponent';
import LoginTitleComponent from './frontend/components/LoginTitleComponent'
import ImageUploadComponent from './frontend/components/ImageUploadComponent';
import CarouselComponent from './frontend/components/CarouselComponent';

import PostsComponent from "./frontend/admin/posts/PostsComponent";
import PostDetailsComponent from "./frontend/admin/posts/PostDetailsComponent";
import PostCardComponent from "./frontend/admin/posts/PostCardComponent";
import CreatePostComponent from "./frontend/admin/posts/create-post/CreatePostComponent";
import PostCreateMainColComponent from './frontend/admin/posts/create-post/includes/PostCreateMainColComponent';
import PostCreateAddColComponent from './frontend/admin/posts/create-post/includes/PostCreateAddColComponent';

import UserComponent from './frontend/admin/users/edit/UserComponent'
import HomeComponent from './frontend/components/home-page/HomeComponent';





export const componentsProvider = {
    AdminCategoriesComponent,
    ButtonComponent,
    TableItemComponent,
    ProfileComponent,
    LoginTitleComponent,
    CarouselComponent,
    ImageUploadComponent,

    PostsComponent,
    PostDetailsComponent,
    PostCardComponent,
    CreatePostComponent,
    PostCreateMainColComponent,
    PostCreateAddColComponent,

    UserComponent,

    HomeComponent
};
