export interface Profile {
    uuid?: string;
    username: string;
    password?: string;
    email: string;
    roles: Array<string>;
}
