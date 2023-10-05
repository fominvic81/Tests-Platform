import { useEffect, useState } from 'react';

export const useUrlState = <T = unknown>(name: string, defaultValue: T) => {
    const url = new URL(location.href);
    const initialValue = url.searchParams.get(name);
    const serialized = initialValue ? JSON.parse(initialValue) as T : undefined;

    const [state, setState] = useState(serialized ?? defaultValue);

    useEffect(() => {
        const listener = (event: PopStateEvent) => {
            const params = new URLSearchParams(location.search);
            const currentValue = params.get(name);

            setState(currentValue ? JSON.parse(currentValue) as T : defaultValue);
        }

        window.addEventListener('popstate', listener);
        return () => window.removeEventListener('popstate', listener);
    }, []);

    return [state, (value?: T) => {
        if (value === state) return;
        const params = new URLSearchParams(location.search);

        if (!value || value === defaultValue) {
            params.delete(name);
        } else {
            params.set(name, JSON.stringify(value));
        }

        const newUrl = new URL(location.href);
        newUrl.search = params.toString();
        window.history.pushState({}, '', newUrl.href);

        setState(value ?? defaultValue);
    }] as const;
}