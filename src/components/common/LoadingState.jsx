import React from 'react';
import { Loader2 } from 'lucide-react';

const LoadingState = ({ 
  message = "Loading...", 
  size = "default",
  className = "" 
}) => {
  const sizeClasses = {
    sm: "h-4 w-4",
    default: "h-8 w-8", 
    lg: "h-12 w-12"
  };

  return (
    <div className={`flex flex-col items-center justify-center py-12 ${className}`}>
      <Loader2 className={`animate-spin text-slate-400 ${sizeClasses[size]}`} />
      <p className="mt-4 text-slate-600 font-medium">{message}</p>
    </div>
  );
};

const LoadingCard = ({ title, className = "" }) => (
  <div className={`bg-white rounded-lg border border-slate-200 p-6 ${className}`}>
    {title && <h3 className="text-lg font-semibold text-slate-900 mb-4">{title}</h3>}
    <LoadingState size="sm" />
  </div>
);

const LoadingSkeleton = ({ lines = 3, className = "" }) => (
  <div className={`space-y-3 ${className}`}>
    {Array.from({ length: lines }).map((_, i) => (
      <div key={i} className="animate-pulse">
        <div className={`h-4 bg-slate-200 rounded ${
          i === lines - 1 ? 'w-3/4' : 'w-full'
        }`}></div>
      </div>
    ))}
  </div>
);

export { LoadingState, LoadingCard, LoadingSkeleton };
export default LoadingState;