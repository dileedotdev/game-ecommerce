const pages = import.meta.glob("../Pages/**/*.vue");

export async function importPageComponent(name: string) {
    // eslint-disable-next-line no-restricted-syntax
    for (const path in pages) {
        if (path.endsWith(`${name}.vue`)) {
            return (await pages[path]()).default;
        }
    }

    throw new Error(`Page not found: ${name}`);
}
