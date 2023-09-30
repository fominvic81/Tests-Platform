import React, { useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import { testExaminatorComponentId } from '..';

const Component: React.FC = () => {

    return <></>;
}

const root = createRoot(document.getElementById(testExaminatorComponentId)!);
root.render(<Component></Component>);