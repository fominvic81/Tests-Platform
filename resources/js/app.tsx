import { createRoot } from 'react-dom/client';
import React, { Suspense } from 'react';


const testRoot = document.getElementById('test-editor');
if (testRoot) {
    const TestEditor = React.lazy(() => import('./pages/test-editor'));
    const root = createRoot(testRoot);

    root.render(
        <TestEditor></TestEditor>
    );
}

import axios from 'axios';
// @ts-ignore
window.axios = axios;