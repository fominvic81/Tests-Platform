import React, { useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import { testExaminatorId } from '..';

const Examinator: React.FC = () => {

    return <></>;
}

const root = createRoot(document.getElementById(testExaminatorId)!);
root.render(
    <Examinator></Examinator>
);