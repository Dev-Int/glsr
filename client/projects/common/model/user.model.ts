import { Profile } from './profile.model';

export interface User {
    profile: Profile;
    token?: string;
}
