export const regexRules = {
    // Allow English and Chinese names with spaces.
    name: /^[\p{L}\s]+$/u,
    // Allow letters, numbers, spaces and common address symbols.
    address: /^[\p{L}\p{N}\s,.-]+$/u,
    phone: /^1[3-9]\d{9}$/,
    email: /^[^@]+@[^@]+\.[^@]+$/,
    username: /^[A-Za-z0-9]{6,}$/,
    password: /^[A-Za-z0-9]{6,}$/
};
