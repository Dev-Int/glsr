export class JwtHelper {
  static decode(token: string): string {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+')
      .replace(/_/g, '/');

    return JSON.parse(window.atob(base64));
  }

  static isExpired(token: string): boolean {
    if (token === null || token === '') {
      return true;
    }

    const date = JwtHelper.getTokenExpirationDate(token);

    return date === null || date.valueOf() <= new Date().valueOf();
  }

  static getTokenExpirationDate(token: string): Date | null {
    let decoded: any;
    decoded = JwtHelper.decode(token);

    if (!decoded.hasOwnProperty('exp')) {
      return null;
    }

    const date = new Date(0);
    date.setUTCSeconds(decoded.exp);

    return date;
  }
}
