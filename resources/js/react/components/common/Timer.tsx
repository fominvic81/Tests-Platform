import cn from 'classnames';
import React, { useEffect, useState } from 'react';

interface Props {
    end: number;
    onTimeover?: () => any;
}

export const Timer: React.FC<Props> = ({ end, onTimeover }) => {
    
    const getCurrentTime = () => (end - Date.now()) / 1000;
    
    const [time, setTime] = useState(getCurrentTime());
    const hours = Math.floor(time / 60 / 60);
    const minutes = Math.floor(time / 60 % 60).toString().padStart(2, '0');
    const seconds = Math.floor(time % 60).toString().padStart(2, '0');

    useEffect(() => {
        let interval = setInterval(() => {
            const currentTime = getCurrentTime();
            if (currentTime < 0 && onTimeover) {
                onTimeover();
            }
            setTime(Math.max(0, currentTime));
        }, 1000);
        return () => clearInterval(interval);
    }, []);

    return <div className={cn('px-3 py-2 w-fit rounded-b-lg text-2xl font-mono font-bold text-gray-600 transition-colors', time > 60 ? 'bg-white ' : 'bg-red-500')}>
        { hours > 0 && <>{ hours }:</>}{ minutes }:{ seconds }
    </div>
}